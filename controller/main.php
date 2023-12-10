<?php
/**
 * Main Home Page Controller
 */
class main extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index(){
		$data['title'] = "Inde Page";
		$this->view("layouts/header",$data);
		$this->view("main/main",$data);
		$this->view("layouts/footer",$data);
	}
}
?>