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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users", "id")->onDelete("cascade");
            $table->foreignId("event_id")->constrained("events", "id")->onDelete("cascade");
            $table->enum("status", ["not started", "ongoing", "finished"]);
            $table->longText("review")->nullable();
            $table->integer("stars")->nullable();
            $table->string("payment_url")->nullable();
            $table->integer("is_payment_validated")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
