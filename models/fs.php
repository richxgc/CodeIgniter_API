<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * CREDITS: developed by @grcardo under MIT licence
 * CLASS: Tw class is a CodeIgniter Model
 * VERSION: 0.0.2
 * DATE: 03-08-2012
 * DESCRIPTION: the fs class provide easy access to functions of library: Foursquare Async developed by jmathai
 * into CodeIgniter environment -> //https://github.com/jmathai/foursquare-async
 */

//NOTE: remains on development, this is for reference not for production

class Fs extends CI_Model{

	var $client_id = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	var $client_secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

	function __construct(){
		parent::__construct();
		//load Foursquare Async Library
		include 'application/libraries/EpiCurl.php';
		include 'application/libraries/EpiSequence.php';
		include 'application/libraries/EpiFoursquare.php';
	}

	//endpoint at https://developer.foursquare.com/docs/venues/explore
	function explore_venues($data){
		$foursquare_obj = new EpiFoursquare($this->client_id, $this->client_secret);
		return $foursquare_obj->get('/venues/explore',$data);
	}
}
?>