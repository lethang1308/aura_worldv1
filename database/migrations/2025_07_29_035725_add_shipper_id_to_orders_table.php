<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyShipperIdToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nếu chưa có cột shipper_id thì thêm
            if (!Schema::hasColumn('orders', 'shipper_id')) {
                $table->unsignedBigInteger('shipper_id')->nullable()->after('status_order');
            }

            // Thêm khóa ngoại
            $table->foreign('shipper_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // Nếu user bị xoá thì shipper_id = null
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipper_id']);
            $table->dropColumn('shipper_id');
        });
    }
}
