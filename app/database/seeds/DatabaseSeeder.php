<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('CapabilitySeeder');
        $this->call('SettingsSeeder');
        $this->call('RoleSeeder');
    }

}

class CapabilitySeeder extends Seeder
{

    protected $stdCapabilites =  array(
                                        // posts
                                        1 => 'createPost',
                                        2 => 'updatePost',
                                        3 => 'publishPost',
                                        4 => 'unpublishPost',
                                        5 => 'changePostState',
                                        6 => 'deletePost',
                                        7 => 'undeletePost',
                                        8 => 'truedeletePost',
                                        9 => 'seeDeletedPosts',
                                        // categories
                                        20 => 'createCategory',
                                        21 => 'updateCategory',
                                        22 => 'deleteCategory',
                                        23 => 'undeleteCategory',
                                        24 => 'forcedeleteCategory',
                                        25 => 'seeArchivedCategories',
                                        // users
                                        30 => 'seeUsers',
                                        31 => 'createUser',
                                        32 => 'updateUser',
                                        33 => 'deleteUser',
                                        34 => 'blockUser',
                                        35 => 'unblockUser',
                                        // roles
                                        40 => 'seeRoles',
                                        41 => 'createRole',
                                        42 => 'updateRole',
                                        43 => 'deleteRole',
                                        // other
                                        50 => 'siteSettings',
                                        // images
                                        70 => 'createImage',
                                        71 => 'updateImage',
                                        72 => 'deleteImage',
                                        // only add in bottom of list
                                      );
    public function run()
    {
        DB::table('capabilities')->delete();
        foreach ($this->stdCapabilites as $id => $cap) {
            Capability::create(array(
                'id' => $id,
                'name' => $cap,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ));
        }
    }
}

class SettingsSeeder extends Seeder
{
    protected $stdSettings = array(
                                  1 => array('blogName', 'Red Panda Blog'),
                               );

    public function run()
    {
        DB::table('settings')->delete();
        foreach ($this->stdSettings as $id => $settings) {
            Setting::create(array(
                'id' => $id,
                'meta_key' => $settings[0],
                'meta_value' => $settings[1],
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ));
        }
    }
}

class RoleSeeder extends Seeder
{
    protected $stdRoles = array(
                              1 => 'admin',
                            );

    public function run()
    {
        DB::table('roles')->delete();
        foreach ($this->stdRoles as $id => $role) {
            Role::create(array(
                'id' => $id,
                'name' => $role,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ));
        }
    }

}

