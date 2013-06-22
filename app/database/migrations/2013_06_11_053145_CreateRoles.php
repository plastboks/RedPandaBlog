<?php

use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('roles', function($table)
    {
      $table->increments('id');

      $table->string('name', 256);

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
    Schema::drop('roles');
	}

}
