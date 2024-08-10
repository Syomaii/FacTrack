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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('office_id');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->string('firstname', 50);
            $table->string("lastname", 50);
            $table->string("email", 50)->unique();
            $table->string("password", 255);
            $table->string("mobile_no", 50);
            $table->string("image", 255)->nullable();
            $table->string("status", 50);
            $table->string("type", 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
