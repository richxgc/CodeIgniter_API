<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//https://github.com/jmathai/foursquare-async
class Fs extends CI_Model{

	var $clientid = 'XXXXXXXX';
	var $clientsecret = 'XXXXXXXXXX';

	function __construct(){
		parent::__construct();
		//load Foursquare Async Library
		include 'application/libraries/EpiCurl.php';
		include 'application/libraries/EpiSequence.php';
		include 'application/libraries/EpiFoursquare.php';
	}
	//https://developer.foursquare.com/docs/venues/explore
	function explore_venues($data){
		$foursquare_obj = new EpiFoursquare($clientid,$clientsecret);
		return $foursquare_obj->get('venues/explore',$data);
	}
}
?>