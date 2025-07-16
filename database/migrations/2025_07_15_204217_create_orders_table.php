<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_address')->nullable();
            $table->text('user_note')->nullable();
            $table->string('status_order')->default('pending');
            $table->string('status_payment', 55)->default('unpaid');
            $table->string('type_payment')->nullable();
            $table->decimal('total_price', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};