<?php

class Update_Category {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up() {
    Schema::table('categories', function($table) {
      $table->timestamps();
    });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down() {
    Schema::table('categories', function($table) {
      //$table->drop_timestamps();
    });
  }

}
