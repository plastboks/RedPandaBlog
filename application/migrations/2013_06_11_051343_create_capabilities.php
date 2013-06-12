<?php

class Create_Capabilities {

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
      $table->string('name');
      $table->timestamps();
    });

    $stdCapabilites =  array(
                                // posts
                                'createPost',
                                'updatePost',
                                'publishPost',
                                'unpublishPost',
                                'changePostState',
                                'deletePost',
                                // categories
                                'createCategory',
                                'updateCategory',
                                'deleteCategory',
                                // users
                                'createUser',
                                'updateUser',
                                'deleteUser',
                                'blockUser',
                                'unblockUser',
                                // roles
                                'createRole',
                                'updateRole',
                                'deleteRole',
                                // other
                                'siteSettings',
                            );
    foreach ($stdCapabilites as $cap) {
      DB::table('capabilities')->insert(array(
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
    Schema::drop('capabilities');
  }

}
