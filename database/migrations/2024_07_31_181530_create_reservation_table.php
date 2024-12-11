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
        Schema::create('reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reservers_id_no');
            $table->unsignedInteger('equipment_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('facility_id');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->dateTime('reservation_start_date');
            $table->dateTime('expected_end_date');
            $table->dateTime('reservation_end_date');
            $table->enum('reservation_type', ['Facility', 'Equipment']);
            $table->enum('status', ['pending', 'approved', 'declined', 'completed', 'cancelled']);
            $table->text('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
