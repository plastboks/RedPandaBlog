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
                                        // categories
                                        7 => 'createCategory',
                                        8 => 'updateCategory',
                                        9 => 'deleteCategory',
                                        // users
                                        10 => 'seeUsers',
                                        11 => 'createUser',
                                        12 => 'updateUser',
                                        13 => 'deleteUser',
                                        14 => 'blockUser',
                                        15 => 'unblockUser',
                                        // roles
                                        16 => 'seeRoles',
                                        17 => 'createRole',
                                        18 => 'updateRole',
                                        19 => 'deleteRole',
                                        // other
                                        20 => 'siteSettings',
                                        // images
                                        21 => 'createImage',
                                        22 => 'updateImage',
                                        23 => 'deleteImage',
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

