<?php

class Create_Cats_Posts {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cats_posts', function($table){
      $table->increments('id');
      $table->integer('post');
      $table->integer('category');

    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cats_posts');
	}

}
