<?php

use Illuminate\Database\Migrations\Migration;

class CreateConfig extends Migration
{

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('settings', function($table)
    {
      $table->increments('id');
      $table->string('meta_key', 128);
      $table->string('meta_value');

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
    Schema::drop('settings');
  }

}
