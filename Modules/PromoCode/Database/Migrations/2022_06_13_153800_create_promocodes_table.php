<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code', 20)->unique()->index();
            $table->integer('usages')->default(1);
            $table->boolean('bound_to_user')->default(false);
            $table->boolean('multi_use')->default(false);
            $table->float('minimum_order')->nullable();
            $table->float('maximum_discount')->nullable();
            $table->enum('discount_type', ['Fixed', 'Percentage', 'FreeAddon']);
            $table->string('discount_value');
            $table->timestamp('expired_at')->nullable();
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
        Schema::drop('promocodes');
    }
}
