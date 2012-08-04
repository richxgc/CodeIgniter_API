<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * CREDITS: developed by @grcardo under MIT licence
 * CLASS: Fb class is a CodeIgniter Model
 * VERSION: 0.2.2
 * DATE: 03-08-2012
 * DESCRIPTION: the fb class provide easy access to functions of library Facebook PHP SDK
 * into CodeIgniter environment
 */
class Fb extends CI_Model{

	//set your application keys
	var $appid = 'xxxxxxxx';
	var $secret = 'xxxxxxxxxxxxxxxxxxxx';

	function __construct(){

		parent::__construct();

		//load facebook library
		$fbconfig = array('appId' => $this->appid,'secret' => $this->secret,'fileUpload' => true);
		$this->load->library('Facebook',$fbconfig);
	}
	/* FUNCTION: get_auth_url()
	 * PARAMETERS: none
	 * RETURNS: the url to get facebook access token
	 * DESCRIPTION: get link to facebook user login
	 */
	function get_auth_url(){
		//note: change redirect uri index
		$config = array(
			'scope' => 'email,user_birthday,publish_stream,publish_actions,read_friendlists',
        	'redirect_uri' => base_url().'index.php/your_controller/your_fb_function'
        );
		return $this->facebook->getLoginUrl($config);
	}
	/* FUNCTION: get_by_id()
	 * PARAMETERS: a valid facebook id
	 * RETURNS: an array with the facebook account user information
	 * DESCRIPTION: this function not require an access token on session
	 */
	function get_by_id($fb_id){
    	$profile = null;
        try{
         	$profile = $this->facebook->api('/'.$fb_id,'GET');
      	} catch (FacebookApiException $e){
            error_log($e);
		}		
       	return $profile;
	}
	/*
	 * FUNCTION: get_current_user()
	 * PARAMETERS: none
	 * RETURNS: This method returns the Facebook User ID of the current user, or 0 if there is no logged-in user.
	 * DESCRIPTION: the function was included by the facebook joke, of set tokens length at 60 days
	 */
	function get_current_user(){
		return $this->facebook->getUser();
	}
	/*
	 * FUNCTION: get_access_token()
	 * PARAMETERS: none
	 * RETURNS: Get the current access token for storing in the database and use it with the function set_accces_token() 
	 * DESCRIPTION: the function was included by the facebook joke, of set tokens length at 60 days
	 */
	function get_access_token(){
		return $this->facebook->getAccessToken();
	}
	/*
	 * FUNCTION: set_access_token()
	 * PARAMETERS: facebook token stored on database, this is for applications we haven't offline support (since 7 / 2012)
	 * RETURNS: This method returns the Facebook User ID of the current user, or 0 if there is no logged-in user.
	 * DESCRIPTION: the function was included by the facebook joke, of set tokens length at 60 days
	 */
	function set_access_token($token){
		$this->facebook->setAccessToken($token);
	}
	/* FUNCTION: get_user()
	 * PARAMETERS: none
	 * RETURNS: an array with the facebook account user information
	 * DESCRIPTION: the function returned all data of facebook account, the function
	 * only works if the user session exists (of auth dialog user access or via set_access_token function)
	 */
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
	/* FUNCTION: post_wall()
	 * PARAMETERS: the message to be posted on facebook, if message include a link send into second parameter
	 * RETURNS: if user is logged in, return facebook response, else return false
	 * DESCRIPTION: facebook response return post id if the calls ends successful, 
	 * or exception that will be show with error_log() functionm, this error is common with token is invalid
	 */
	function post_wall($message, $link=null){
		$response = null;
		$user = $this->facebook->getUser();
		if($user){
			try {
				$data = array('link'=>$link,'message'=>$message);
				$response = $this->facebook->api('/me/feed','POST',$data);
			} catch (FacebookApiException $e) {
				$response = $e;
			}
			return $response;
		}
		else{
			return FALSE;
		}
		
	}
}
?>