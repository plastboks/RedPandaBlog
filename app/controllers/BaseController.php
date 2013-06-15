<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Loads some IoC classes into the BaseController
	 *
	 * @return void
	 */
  public function __construct()
  {
    $this->s = App::make('settings');
    $this->p = App::make('permissions');
  }

}
