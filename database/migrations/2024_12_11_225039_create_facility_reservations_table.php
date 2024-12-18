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
        Schema::create('facility_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reservers_id_no');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('facility_id');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->time('time_in');
            $table->time('time_out');
            $table->enum('status', ['pending', 'approved', 'declined', 'completed', 'cancelled']);
            $table->text('purpose');
            $table->integer('expected_audience_no');
            $table->integer('stage_performers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_reservations');
    }
};
