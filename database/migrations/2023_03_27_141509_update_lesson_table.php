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
        Schema::table('lesson', function (Blueprint $table) {
            $table->string('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->integer('amount');
            $table->string('currency');
            $table->dateTimeTz('start_date');
            $table->dateTimeTz('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropColumn('teacher_id');
            $table->dropColumn('amount');
            $table->dropColumn('currency');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
