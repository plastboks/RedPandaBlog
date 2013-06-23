<?php
/**
 * File: AdminSettingController
 * 
 * PHP version 5.4
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * 
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 * 
 */


/**
 * Class AdminSettingController
 *
 * @category Development
 * @package  BaseController
 * @author   Alexander Skjolden <alex@plastboks.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 *
 * @link     http://github.com/plastboks/red-panda-blog
 * @date     2013-06-17
 *
 */
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
        $this->beforeFilter('auth');
    }

    /**
     * Edit settings view
     *
     * @return view
     */
    public function getEdit()
    {
        if ($this->p->canI('siteSettings')) {
            $data = array(
                'status' => Session::get('status'),
            );
            return View::make('admin/setting/edit', $data);
        }
        return App::abort(403, 'Forbidden');
    }

    /**
     * Register site setting action
     *
     * @return redirect
     */
    public function postRegister()
    {
        if (!$this->p->canI('siteSettings')) {
            return App::abort(403, 'Forbidden');
        }

        $v = Validator::make(Input::all(), Setting::defaultRules());

        if ($v->fails()) {
            return Redirect::back()
                      ->withErrors($v)
                      ->withInput();
        }

        $this->_addMetaData('blogName', Input::get('blogName'));
        $this->_addMetaData('footer', Input::get('footertext'));
        $this->_addMetaData('postsPerPage', Input::get('postsperpage'));
        $this->_addMetaData('excerptCut', Input::get('excerptCut'));
        $this->_addMetaData('frontpagecategory', Input::get('frontpagecategory'));

        return Redirect::back()
                  ->with('status', 'Site settings updated');
    }

    /**
     * Register site setting action
     *
     * @param int $key   setting_key
     * @param int $value setting_value
     *
     * @return redirect
     */
    private function _addMetaData($key, $value)
    {
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

