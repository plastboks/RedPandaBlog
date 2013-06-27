<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration
{

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
    Schema::drop('categories');
  }

}
