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
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en', 60);
            $table->string('name_ar', 60);
            $table->string('slug_en', 60)->index()->unique();
            $table->string('slug_ar', 60)->index()->unique();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('status')->index()->default(1);
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
        Schema::dropIfExists('blogs');
    }
};
