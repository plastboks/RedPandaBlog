<?php

use Illuminate\Database\Migrations\Migration;

class CreateImagesPosts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_post', function($table)
        {
          $table->increments('id');

          $table->integer('image_id');
          $table->integer('post_id');

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
        Schema::drop('image_post');
    }

}
