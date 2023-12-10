<?php
/**
 * About Us
 */
class about extends Controller{
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$data['title'] = "About Us";
		$this->view("layouts/header",$data);
		$this->view("pages/about",$data);
		$this->view("layouts/footer",$data);
	}
}

?>