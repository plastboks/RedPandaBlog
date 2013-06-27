<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{

  /**
   * Make changes to the database.
   *
   * @return void
   */
   public function up() 
   {
      Schema::create('users', function($table) 
      {
        $table->increments('id');

        $table->string('username', 32);
        $table->string('email', 320);
        $table->string('givenname', 120);
        $table->string('surname', 120);

        $table->text('info');

        $table->string('password', 64);
        $table->string('confirmation_code');

        $table->boolean('blocked');
        $table->boolean('confirmed')->default(false);
        $table->boolean('approved')->default(false);
        $table->integer('role_id');
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
    Schema::drop('users');
  }

}
