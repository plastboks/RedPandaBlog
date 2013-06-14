<?php

class Update_Users3 {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('users', function($table) {
      $table->string('givenname');
      $table->string('surname');
      $table->string('info');
    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::table('users', function($table) {
      $table->drop_column('givenname');
      $table->drop_column('surname');
      $table->drop_column('info');
    });
	}

}
