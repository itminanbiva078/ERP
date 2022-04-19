<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_categories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->string('name',55);
            $table->longText('module')->nullable();
            $table->longText('module_details')->nullable();
            $table->string('email',55)->nullable();
            $table->string('password',55)->nullable();
            $table->tinyInteger('is_branch')->nullable()->default(0);
            $table->tinyInteger('is_store')->nullable()->default(0);
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set approved , penidng status waiting for approbal');
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
        Schema::dropIfExists('company_categories');
    }
}