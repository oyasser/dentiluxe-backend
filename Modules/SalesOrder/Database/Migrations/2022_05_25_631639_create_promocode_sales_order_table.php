<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PromoCode\Models\Promocode;
use Modules\SalesOrder\Models\SalesOrder;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('promocode_sales_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(SalesOrder::class);
            $table->foreignIdFor(Promocode::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocode_sales_order');
    }
};
