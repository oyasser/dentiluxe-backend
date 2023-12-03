<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @retur
     * n void
     */
    public function up()
    {
        Schema::create('item_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('price_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('client_category_id')->nullable();
            $table->decimal('price')->default(0.00);
            $table->decimal('discount_price')->default(0.00);
            $table->integer('discount_rate')->default(0);
            $table->index(['item_id', 'price_id']);

            $table->foreign('price_id')
                ->references('id')
                ->on('prices')
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
        Schema::dropIfExists('item_price');
    }
};
