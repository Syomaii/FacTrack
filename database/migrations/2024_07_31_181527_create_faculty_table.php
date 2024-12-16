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
        Schema::create('faculty', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 50);
            $table->string('department', 100);
            $table->integer('overdue_count')->default(0);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('faculty');
    }
};
