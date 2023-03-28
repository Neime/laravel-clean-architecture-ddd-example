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
        Schema::table('book', function (Blueprint $table) {
            $table->string('transaction_id')->unsigned()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->dropColumn('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book', function($table) {
            $table->dropColumn('transaction_id');
            $table->string('payment_status')->default('new');
        });
    }
};
