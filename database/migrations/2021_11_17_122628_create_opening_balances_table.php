<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_balances', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('account_id')->unsigned();
            $table->float('debit', 12, 2)->nullable();
            $table->float('credit', 12, 2)->nullable();
            $table->text('memo')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel','Partial Received'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('opening_balances');
    }
}
