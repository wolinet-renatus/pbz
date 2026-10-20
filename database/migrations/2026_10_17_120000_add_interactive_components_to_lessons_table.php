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
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'content_type')) {
                $table->string('content_type', 50)->default('video')->after('title');
            }
            if (!Schema::hasColumn('lessons', 'component_data')) {
                $table->longText('component_data')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'content_type')) {
                $table->dropColumn('content_type');
            }
            if (Schema::hasColumn('lessons', 'component_data')) {
                $table->dropColumn('component_data');
            }
        });
    }
};
