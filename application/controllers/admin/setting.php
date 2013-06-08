<?php

class Admin_Setting_Controller extends Base_Controller
{
    public function __construct() 
    {
        $this->filter('before', 'auth');
    }
    
    public function action_edit() {
        return View::make('admin/setting/edit');
    }

    public function action_register() {

        $v = Validator::make(Input::all(), Setting::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/settings')
                  ->with_errors($v)
                  ->with_input();
        }

        if ($setting = Setting::where('meta_key', '=', 'blogName')->first()) {
          $setting->meta_value = Input::get('blogName');
          $setting->save();
        }

        if ($setting = Setting::where('meta_key', '=', 'footer')->first()) {
          $setting->meta_value = Input::get('footertext');
          $setting->save();
        }

        return Redirect::to('admin/settings');

    }
}
