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
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_id');
            $table->unsignedInteger('user_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('repaired_date');
            $table->dateTime('returned_date')->nullable();
            $table->text('remarks');
            $table->text('issue');
            $table->string('action_taken', 255)->nullable();
            $table->string('recommendations', 255)->nullable();
            $table->string('technician', 255)->nullable();
            $table->string('status', 50);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
