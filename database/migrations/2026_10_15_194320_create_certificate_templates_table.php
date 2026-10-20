<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('orientation', ['landscape', 'portrait'])->default('landscape');
            $table->string('background_image')->nullable();
            $table->unsignedInteger('valid_for_months')->nullable(); // null = lifetime
            $table->unsignedInteger('canvas_width')->default(842);
            $table->unsignedInteger('canvas_height')->default(595);
            $table->json('elements')->nullable();
            $table->text('custom_css')->nullable();
            $table->longText('custom_html')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('issued_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        if (Schema::hasTable('courses') && !Schema::hasColumn('courses', 'certificate_template_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->foreignId('certificate_template_id')->nullable()->after('instructor_id')->constrained('certificate_templates')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('courses') && Schema::hasColumn('courses', 'certificate_template_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropForeign(['certificate_template_id']);
                $table->dropColumn('certificate_template_id');
            });
        }

        Schema::dropIfExists('certificate_templates');
    }
};
