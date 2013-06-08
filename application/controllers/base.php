<?php

class Base_Controller extends Controller {
 
  public $s;

  /**
   * Catch-all method for requests that can't be matched.
   *
   * @param  string    $method
   * @param  array     $parameters
   * @return Response
   */
  public function __call($method, $parameters)
  {
    return Response::error('404');
  }

  public function __construct()
  {
    $this->s = IoC::resolve('settings');
  }
  
}
