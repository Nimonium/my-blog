<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable();
        });
        Schema::table('headlines', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable();
        });
        Schema::table('help_videos', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
        Schema::table('headlines', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
        Schema::table('help_videos', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
};
