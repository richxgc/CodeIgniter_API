<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * CREDITS: developed by @grcardo under MIT licence
 * CLASS: Fb class is a CodeIgniter Model
 * VERSION: 0.2.1
 * DATE: 26-06-2012
 * DESCRIPTION: the fb class provide easy access to functions of library Facebook PHP SDK
 * into CodeIgniter environment
*/
class Fb extends CI_Model{

	var $appid = 'XXXXX';
	var $secret = 'XXXXXXXXXX';

	function __construct(){
		parent::__construct();
		//load facebook library
		$fbconfig = array('appId' => $this->appid,'secret' => $this->secret,'fileUpload' => true);
		$this->load->library('Facebook',$fbconfig);
	}

	function get_by_id($fb_id){
    	$profile = null;
        try{
         	$profile = $this->facebook->api('/'.$fb_id,'GET');
      	} catch (FacebookApiException $e){
            error_log($e);
		}		
       	return $profile;
	}

	function get_auth_url(){
		$config = array(
			'scope' => 'email,user_birthday,publish_stream,publish_actions,read_friendlists',
        	'redirect_uri' => base_url().'redirect to.....'
        );
		return $this->facebook->getLoginUrl($config);
	}

	function get_user(){
		$profile = null;
		$user = $this->facebook->getUser();
		if($user){
			try {
				$profile = $this->facebook->api('/me','GET');
			} catch (FacebookApiException $e) {
				error_log($e);
			}
		}
		return $profile;
	}

	function post_wall($message, $link=null){
		$msg = null;
		$user = $this->facebook->getUser();
		if($user){
			try {
				$data = array('link'=>$link,'message'=>$message);
				$msg = $this->facebook->api('/me/feed','POST',$data);
			} catch (FacebookApiException $e) {
				error_log($e);
			}
		}
		return $msg;
	}
}
?>