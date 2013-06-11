<?php

class Create_Capabilities {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('capabilites', function($table)
    {
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });

    $stdCapabilites =  array(
                                'everything',
                                'createPost',
                                'updatePost',
                                'publishPost',
                                'unpublishPost',
                                'changePostState',
                                'deletePost',
                                'createCategory',
                                'deleteCategory',
                                'editCategory',
                            );
    foreach ($stdCapabilites as $cap) {
      DB::table('capabilites')->insert(array(
                                       'name' => $cap,
                                      ));
    }

  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('capabilites');
  }

}
