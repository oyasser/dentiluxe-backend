<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en', 50);
            $table->string('name_ar', 50);
            $table->string('slug_en', 50);
            $table->string('slug_ar', 50);
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->decimal('rate')->default(0.00);

            $table->boolean('is_default')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
