<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTheamColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theam_colors', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->string('themes_bg_color',55)->nullable();
            $table->string('sidebar_bg_color',55)->nullable();
            $table->string('sidebar_drop_bg_color',55)->nullable();
            $table->string('menu_font_color',55)->nullable();
            $table->string('main_font_color',55)->nullable();
            $table->string('red_color',55)->nullable();
            $table->string('success_color',55)->nullable();
            $table->string('border_color',55)->nullable();
            $table->string('block_color',55)->nullable();
            $table->string('icon_color',55)->nullable();
            $table->string('button_bg_color',55)->nullable();
            $table->string('button_font_color',55)->nullable();
            $table->string('placeholder_color',55)->nullable();
            $table->string('readonly_color',55)->nullable();
            $table->string('input_background_color',55)->nullable();
            $table->string('input_text_color',55)->nullable();
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
        Schema::dropIfExists('theam_colors');
    }
}
