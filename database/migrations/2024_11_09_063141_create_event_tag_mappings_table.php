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
        Schema::create('event_tag_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events', 'id')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags', 'id')->onDelete('cascade');
            $table->integer("score")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_tag_mappings');
    }
};
