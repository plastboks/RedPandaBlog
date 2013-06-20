<?php

use Illuminate\Database\Migrations\Migration;

class UpdateImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      Schema::table('images', function($table)
      {
          $table->string('uploader');
      });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
      // no way back...
	}

}
