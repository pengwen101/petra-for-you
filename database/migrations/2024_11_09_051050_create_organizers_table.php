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
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 64);
            $table->longText('description');
            $table->enum('type', ['universitas', 'fakultas', 'jurusan', 'lembaga kemahasiswaan']);
            $table->string('instagram_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('line_id')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};
