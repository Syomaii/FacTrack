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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_id');
            $table->unsignedInteger('user_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('maintained_date');
            $table->dateTime('returned_date')->nullable();
            $table->string('remarks', 255);
            $table->string('status', 50);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
