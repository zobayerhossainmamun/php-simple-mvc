<?php
/**
 * This class used to render view from controller
 * 
 * Class  Controller
 * Extends Bootstrap
 */
class Controller extends Bootstrap {

	public function __construct(){
		parent::__construct();
	}
	public function view($path,$data = false, $error = false){
		require DOCROOT."/views/$path.phtml";
	}
}
