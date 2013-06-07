<?php

class Create_Cats_Posts {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up() {
    Schema::create('category_post', function($table){
      $table->increments('id');
      $table->integer('post_id');
      $table->integer('category_id');

      $table->timestamps();
    });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down() {
    Schema::drop('category_post');
  }

}
