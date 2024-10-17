<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create users table migration.
 *
 * This migration creates the `users` table with the following columns:
 * - `id`: auto-incrementing primary key
 * - `designation_id`: unsigned integer referencing the `id` column on the `designations` table
 * - `office_id`: unsigned integer referencing the `id` column on the `offices` table
 * - `firstname`: string with a maximum length of 50 characters
 * - `lastname`: string with a maximum length of 50 characters
 * - `email`: unique string with a maximum length of 50 characters
 * - `password`: string with a maximum length of 255 characters
 * - `mobile_no`: string with a maximum length of 50 characters
 * - `image`: nullable string with a maximum length of 255 characters
 * - `status`: string with a maximum length of 50 characters
 * - `type`: string with a maximum length of 50 characters
 * - `created_at` and `updated_at`: timestamp columns for tracking creation and update times
 *
 * Example:
 * ```bash
 * php artisan migrate
 * ```
 * This will create the `users` table with the specified columns.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the `users` table with the specified columns.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('designation_id')->nullable();
            $table->unsignedInteger('office_id')->nullable();
            $table->index('office_id');
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
     *
     * Drops the `users` table.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};