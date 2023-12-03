<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('item_sales_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_order_id')->index();
            $table->unsignedBigInteger('item_id')->index();
            $table->unsignedInteger('qty');
            $table->decimal('price')->default(0.00);

            $table->foreign('sales_order_id')
                ->references('id')
                ->on('sales_orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_sales_order');
    }
};
