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
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('facility_id');
            $table->unsignedInteger('user_id');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('brand', 50);
            $table->string('name', 255);
            $table->string('serial_no', 255);
            $table->text('description');
            $table->dateTime('acquired_date');
            $table->string('code', 255);
            $table->string('image', 255);
            $table->string('status', 50);
            $table->string('owned_by', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
