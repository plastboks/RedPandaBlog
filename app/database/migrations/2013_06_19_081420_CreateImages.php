<?php

use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function($table)
        {
          $table->increments('id');
          $table->string('title');
          $table->string('filename');
          $table->string('uploader');

          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }

}
