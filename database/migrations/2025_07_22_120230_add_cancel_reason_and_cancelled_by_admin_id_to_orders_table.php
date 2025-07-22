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
        Schema::table('orders', function (Blueprint $table) {
            $table->text('cancel_reason')->nullable()->after('user_note');
            $table->unsignedBigInteger('cancelled_by_admin_id')->nullable()->after('cancel_reason');
            $table->foreign('cancelled_by_admin_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by_admin_id']);
            $table->dropColumn(['cancel_reason', 'cancelled_by_admin_id']);
        });
    }
};
