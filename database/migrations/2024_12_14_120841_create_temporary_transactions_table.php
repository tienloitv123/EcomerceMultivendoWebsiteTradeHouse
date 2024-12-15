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
        Schema::create('temporary_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_wallet_id');
            $table->unsignedBigInteger('seller_wallet_id');
            $table->unsignedBigInteger('order_id')->nullable()->constrained()->onDelete('cascade');            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, canceled
            $table->timestamps();

            $table->foreign('client_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('seller_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_transactions');
    }
};
