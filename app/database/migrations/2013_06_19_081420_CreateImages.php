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

          $table->string('title', 512);
          $table->string('filename', 512);

          $table->integer('uploader_id');

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
