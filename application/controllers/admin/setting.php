<?php

class Admin_Setting_Controller extends Base_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->filter('before', array('auth'));
    }
    
    public function action_edit() {
        if ($this->p->canI('siteSettings')) {
            return View::make('admin/setting/edit', array(
                                                        'status' => Session::get('status'),
                                                      ));
        }
        return Redirect::error(403);
    }

    public function action_register() {

        if (!$this->p->canI('siteSettings')) {
          return Redirect::error(403);
        }

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

        return Redirect::to('admin/settings')
                  ->with('status', 'Site settings updated');
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
