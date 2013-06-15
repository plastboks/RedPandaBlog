<?php

class Update_Users4 {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function($table)
    {
      $table->string('confirmation_code');
      $table->boolean('confirmed')->default(false);
      $table->boolean('approved')->default(false);
    });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function($table)
    {
      $table->drop_column('confirmation_code');
      $table->drop_column('confirmed');
      $table->drop_column('approved');
    });
  }

}
