<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->string('code', 20)->unique()->comment('PID000001')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('image')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->string('type_id')->default('POS Product')->nullable();
            $table->string('floor_id')->nullable();
            $table->float('purchases_price', 12, 2)->nullable();
            $table->float('sale_price', 12, 2)->nullable();
            $table->float('low_stock', 12, 2)->nullable();
            $table->longtext('description')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['category_id', 'brand_id', 'unit_id']);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
