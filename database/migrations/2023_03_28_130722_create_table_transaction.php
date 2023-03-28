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
        Schema::create('transaction', function(Blueprint $table) {
            $table->string('id')->primary();
            $table->string('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallet');
            $table->integer('amount');
            $table->string('currency');
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
