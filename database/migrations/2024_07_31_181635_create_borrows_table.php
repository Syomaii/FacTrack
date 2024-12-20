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
        Schema::create('borrows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_id');
            $table->unsignedInteger('user_id');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('borrowers_id_no');
            $table->foreign('borrowers_id_no')->references('id')->on('students')->onDelete('cascade');
            $table->string('borrowers_name', 100);
            $table->string('department', 50);
            $table->dateTime('borrowed_date');
            $table->dateTime('expected_returned_date');
            $table->dateTime('returned_date')->nullable();
            $table->string('status', 50);
            $table->string('purpose', 50);
            $table->string('remarks', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
