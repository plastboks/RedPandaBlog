<?php

use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration
{

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('posts', function($table)
      {
        $table->increments('id');
        $table->string('title', 256);

        $table->text('body')->nullable();
        $table->text('excerpt')->nullable();

        $table->integer('author_id');
        $table->boolean('archived');
        $table->boolean('published');

        $table->timestamps();
        $table->softDeletes();
      });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down()
  {
      Schema::drop('posts');
  }

}
