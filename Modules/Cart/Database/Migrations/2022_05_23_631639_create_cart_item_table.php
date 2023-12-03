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
        Schema::create('cart_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cart_id')->unsigned()->index();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('qty');
            $table->decimal('price');

            $table->unique(['cart_id', 'item_id']);

            $table->foreign('cart_id')->references('id')
                ->on('cart')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('item_id')->references('id')
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
        Schema::dropIfExists('cart_item');
    }
};
