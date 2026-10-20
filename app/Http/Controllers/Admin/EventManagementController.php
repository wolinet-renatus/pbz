<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventBooking;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Event Management Controller
 *
 * This controller handles the management of events.
 *
 * @package App\Http\Controllers\Admin
 */
class EventManagementController extends Controller
{
    /**
     * Display a listing of events with filters.
     */
    public function index(Request $request): View
    {
        $query = Event::query()->withCount([
            'bookings as confirmed_bookings_count' => function ($q) {
                $q->where('status', EventBooking::STATUS_CONFIRMED);
            },
        ]);

        if ($search = $request->string('search')->trim()->value()) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($status = $request->string('status')->trim()->lower()->value()) {
            if ($status === 'published') {
                $query->where('is_published', true);
            } elseif ($status === 'draft') {
                $query->where('is_published', false);
            }
        }

        if ($timeline = $request->string('timeline')->trim()->lower()->value()) {
            if ($timeline === 'upcoming') {
                $query->whereDate('start_date', '>=', now()->startOfDay());
            } elseif ($timeline === 'past') {
                $query->whereDate('end_date', '<', now()->startOfDay());
            }
        }

        $events = $query->orderByDesc('start_date')->paginate(15)->withQueryString();

        $stats = [
            'total' => Event::count(),
            'published' => Event::where('is_published', true)->count(),
            'upcoming' => Event::whereDate('start_date', '>=', now()->startOfDay())->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    /**
     * Display a single event with detail context.
     */
    public function show(Event $event): View
    {
        $event->load([
            'speakers',
            'highlights',
            'instructors:id,name,email',
            'bookings' => function ($query) {
                $query->latest()->take(20);
            },
        ]);

        $bookingStats = [
            'total' => $event->bookings()->count(),
            'confirmed' => $event->bookings()->where('status', EventBooking::STATUS_CONFIRMED)->count(),
            'pending' => $event->bookings()->where('status', EventBooking::STATUS_PENDING)->count(),
            'seats_available' => $event->remainingSeats(),
        ];

        return view('admin.events.show', compact('event', 'bookingStats'));
    }

    /**
     * Toggle publish status for an event.
     */
    public function togglePublish(Event $event): RedirectResponse
    {
        $event->is_published = ! $event->is_published;
        $event->save();

        ToastMagic::success('Event "' . $event->title . '" is now ' . ($event->is_published ? 'published' : 'hidden') . '.');

        return back();
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $title = $event->title;

        // Clean up uploaded media file if stored in public storage
        if ($event->featured_image && !str_starts_with($event->featured_image, 'events/bot-summit') && !str_starts_with($event->featured_image, 'events/islamic-fintech') && !str_starts_with($event->featured_image, 'events/cyber-defense') && !str_starts_with($event->featured_image, 'events/wakala-rollout')) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($event->featured_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->featured_image);
            }
        }

        // Clean up associations
        $event->highlights()->delete();
        $event->speakers()->delete();
        $event->instructors()->detach();
        $event->bookings()->delete();
        $event->delete();

        ToastMagic::success('Event "' . $title . '" has been permanently deleted.');

        return redirect()->route('admin.events.index');
    }
}

