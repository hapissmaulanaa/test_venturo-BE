<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleUsagesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id');
            $table->string('purpose');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();

            // $table->foreign('booking_id')->references('id')->on('vehicle_bookings')->onDelete('cascade');
            // $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_usages');
    }
}

