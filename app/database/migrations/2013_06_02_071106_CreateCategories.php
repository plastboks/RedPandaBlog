<?php

class CreateCategories {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up() 
  {
    Schema::create('categories', function($table) 
    {
      $table->increments('id');
      $table->string('title');
      $table->string('slug');
      $table->boolean('active');

      $table->timestamps();
    });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down() 
  {
    Schema::drop('categories');
  }

}
