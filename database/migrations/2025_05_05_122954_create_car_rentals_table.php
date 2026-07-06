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
        Schema::create('car_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama')->nullable();

            $table->foreignId('car_id')->constrained()->onDelete('cascade');

            $table->enum('duration_type', ['12', '24', 'custom'])->default('24');

            $table->integer('custom_duration')->nullable();

            $table->dateTime('start_date');

            $table->dateTime('end_date')->nullable();

            $table->enum('status', ['menunggu_konfirmasi', 'booked', 'on_rent', 'selesai', 'dibatalkan', 'ditolak'])->default('menunggu_konfirmasi');

            $table->boolean('with_driver')->default(false);
            $table->unsignedInteger('driver_days')->nullable();

            $table->boolean('with_fuel')->default(false);
            $table->unsignedInteger('fuel_days')->nullable();

            $table->integer('discount')->default(0);
            $table->decimal('total_price', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rentals');
    }
};
