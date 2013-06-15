<?php

class AdminSettingController extends BaseController
{

    /**
     * Sets persmission and load parents contruct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->filter('before', array('auth'));
    }

    /**
     * Edit settings view
     *
     * @return view
     */
    public function getEdit() {
        if ($this->p->canI('siteSettings')) {
            return View::make('admin/setting/edit',
                              array(
                                  'status' => Session::get('status'),
                              ));
        }
        return Redirect::error(403);
    }

    /**
     * Register site setting action
     *
     * @return redirect
     */
    public function getRegister() {
        if (!$this->p->canI('siteSettings')) return Redirect::error(403);

        $v = Validator::make(Input::all(), Setting::defaultRules());

        if ($v->fails()) {
          return Redirect::to('admin/settings')
                    ->withErrors($v)
                    ->withInput();
        }

        $this->addMetaData('blogName', Input::get('blogName'));
        $this->addMetaData('footer', Input::get('footertext'));
        $this->addMetaData('postsPerPage', Input::get('postsperpage'));
        $this->addMetaData('excerptCut', Input::get('excerptCut'));

        return Redirect::to('admin/settings')
                  ->with('status', 'Site settings updated');
    }

    /**
     * Register site setting action
     *
     * @params setting_key, setting_value
     * @return redirect
     */
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

