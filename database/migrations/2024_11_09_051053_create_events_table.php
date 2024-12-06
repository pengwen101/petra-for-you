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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', length: 64);
            $table->string('venue', length: 64);
            $table->date('max_register_date');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->longText('description');
            $table->decimal('price', total: 10, places:2)->nullable();
            $table->foreignId('organizer_id')->constrained('organizers', 'id')->onDelete('cascade');
            $table->integer('is_shown')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
