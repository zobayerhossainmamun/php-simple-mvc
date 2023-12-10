<?php

class Url {
	/**
	 * Redirect to url
	 * @param string $url
	 */
	public static function redirect($url = null){
		header('location: '.DIR.$url);
		exit;
	}
	
	/**
	 * Get images path from directory
	 * @return string
	 */
	public static function get_image_path(){
		return DIR.'assets/images';
	}
}