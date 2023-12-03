<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_number')->index()->unique();
            $table->json('details');
            $table->decimal('sub_total', 20, 6)->default(0);
            $table->decimal('discount', 20, 6)->default(0);
            $table->decimal('total', 20, 6)->default(0);
            $table->enum('status', ['PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELED', 'REJECTED'])->index()->default('PENDING');

            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->nullOnDelete()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_orders');
    }
};
