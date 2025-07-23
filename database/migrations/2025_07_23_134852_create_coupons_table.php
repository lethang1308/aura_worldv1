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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã coupon
            $table->enum('type', ['percent', 'fixed'])->default('fixed'); // Loại giảm giá: phần trăm hoặc cố định
            $table->decimal('value', 10, 2); // Giá trị giảm
            $table->decimal('min_order_value', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->decimal('max_discount', 10, 2)->nullable(); // Số tiền giảm tối đa (nếu là phần trăm)
            $table->dateTime('start_date')->nullable(); // Ngày bắt đầu
            $table->dateTime('end_date')->nullable(); // Ngày kết thúc
            $table->integer('usage_limit')->nullable(); // Số lần sử dụng tối đa
            $table->integer('used')->default(0); // Số lần đã sử dụng
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái
            $table->text('description')->nullable(); // Mô tả
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
