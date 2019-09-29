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
            // Should add ->unsigned() here https://youtu.be/tSmap9D-KCk?t=1937
            // we are not using foreign keys and not referencing to the actual table
            // $table->integer('company_id');
            // $table->integer('tag_id');
            // $table->primary(['company_id', 'tag_id']);

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')-references('id')->on('companies');

            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')-references('id')->on('tags');
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
