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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id')->index();
            $table->string('name_en', 60);
            $table->string('name_ar', 60);
            $table->string('slug_en', 60)->unique()->index();
            $table->string('slug_ar', 60)->unique()->index();
            $table->text('description_en');
            $table->text('description_ar');
            $table->integer('in_stock')->default(1);
            $table->integer('available_stock')->default(0);
            $table->enum('type', ['ITEM', 'SIMPLE', 'MIXED'])->default('ITEM');
            $table->boolean('trending')->default(0)->index();
            $table->boolean('best_seller')->default(0)->index();
            $table->boolean('status')->default(1)->index();
            $table->timestamps();

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
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
        Schema::dropIfExists('items');
    }
};
