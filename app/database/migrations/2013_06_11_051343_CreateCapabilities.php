<?php

use Illuminate\Database\Migrations\Migration;

class CreateCapabilities extends Migration
{

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('capabilities', function($table)
    {
      $table->increments('id');

      $table->string('name', 128);

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
    Schema::drop('capabilities');
  }

}
