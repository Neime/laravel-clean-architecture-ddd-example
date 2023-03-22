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
        Schema::create('book', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('status');
            $table->string('lesson_id')->unsigned();
            $table->foreign('lesson_id')->references('id')->on('lesson');
            $table->string('learner_id')->unsigned();
            $table->foreign('learner_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book');
    }
};
