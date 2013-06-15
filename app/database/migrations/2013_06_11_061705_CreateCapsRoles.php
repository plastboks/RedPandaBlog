<?php

class CreateCapsRoles {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('capability_role', function($table)
    {
      $table->increments('id');
      $table->integer('capability_id');
      $table->integer('role_id');

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
    Schema::drop('capability_role');
  }

}
