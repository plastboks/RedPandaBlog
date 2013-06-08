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
        
        $this->addMetaData('blogName', Input::get('blogName'));
        $this->addMetaData('footer', Input::get('footertext'));
        $this->addMetaData('postsPerPage', Input::get('postsperpage'));
        $this->addMetaData('excerptCut', Input::get('excerptCut'));

        return Redirect::to('admin/settings');
    }

    
    private function addMetaData($key, $value) {
        if ($setting = Setting::where('meta_key', '=', $key)->first()) {
          $setting->meta_value = $value;
          $setting->save();
        } else {
          $setting = new Setting;
          $setting->meta_key = $key;
          $setting->meta_value = $value;
          $setting->save();
        }
    }

}
