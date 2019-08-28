<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });*/

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('company_tag', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('tag_id');
            $table->primary(['company_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('tags');
        Schema::drop('company_tag');
        Schema::drop('tags');
    }
}
