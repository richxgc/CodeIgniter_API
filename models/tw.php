<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * CREDITS: developed by @grcardo under MIT licence
 * CLASS: Tw class is a CodeIgniter Model
 * VERSION: 0.1.4
 * DATE: 03-08-2012
 * DESCRIPTION: the tw class provide easy access to functions of library: Twitter Async developed by jmathai
 * into CodeIgniter environment
 */
class Tw extends CI_Model{

	//set your application keys
	var $consumer_key = 'xxxxxxxxxxx';
	var $consumer_secret = 'xxxxxxxxxxxxxxxxxxxxxxx';

	function __construct(){

		parent::__construct();

		//load Twitter Async Library
		include 'application/libraries/EpiCurl.php';
		include 'application/libraries/EpiOAuth.php';
		include 'application/libraries/EpiSequence.php';
		include 'application/libraries/EpiTwitter.php';

	}
	/* FUNCTION: get_auth_url()
	 * PARAMETERS: none
	 * RETURNS: the url to get twitter access token
	 * DESCRIPTION: get link to twitter user login
	 */
	function get_auth_url(){
		$twitter_obj = new EpiTwitter($this->consumer_key,$this->consumer_secret);
		return $twitter_obj->getAuthenticateUrl();
	}
	/* FUNCTION: set_access_token()
	 * PARAMETERS: none
	 * RETURNS: none
	 * DESCRIPTION: set the user session with access token returned by twitter,
	 * this function must be called only if just arrived from twitter and not
	 * exist any user session
	 */
	function set_access_token(){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		$twitter_obj->setToken($_GET['oauth_token']);
		$token = $twitter_obj->getAccessToken();
		$twitter_obj->setToken($token->oauth_token, $token->oauth_token_secret);
		$this->session->set_userdata('oauth_token', $token->oauth_token);
		$this->session->set_userdata('oauth_token_secret', $token->oauth_token_secret);
	}
	/* FUNCTION: get_by_id()
	 * PARAMETERS: a valid twitter id
	 * RETURNS: an object array with the twitter account user information
	 * DESCRIPTION: this function not require an access token on session
	 */
	function get_by_id($tw_id){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		return $twitter_obj->get('/users/show.json', array('user_id' => $tw_id));
	}
	/* FUNCTION: get_user()
	 * PARAMETERS: none
	 * RETURNS: an object array with the twitter account user information
	 * DESCRIPTION: the function returned all data of twitter account, the function
	 * only works if the user session exists (function previously called set_access_token)
	 * the reference of returned data reside here --> https://dev.twitter.com/docs/api/1/get/account/verify_credentials
	 */
	function get_user(){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		$twitter_obj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
		return $twitter_obj->get('/account/verify_credentials.json');
	}
	/* FUNCTION: get_friends()
	 * PARAMETERS: none
	 * RETURNS: an object array with user friend list
	 */
	function get_friends(){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		$twitter_obj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
		return $twitter_obj->get('/friends/ids.json');
	}
	/* FUNCTION: get_followers()
	 * PARAMETERS: none
	 * RETURNS: an object array with user followers list
	 */
	function get_followers(){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		$twitter_obj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
		return $twitter_obj->get('/followers/ids.json');
	}
	/* FUNCTION: post_tweet()
	 * PARAMETERS: $tweet= the message to be posted on twitter
	 * RETURNS: TRUE if tweet posted correctly or FALSE in another case
	 * DESCRIPTION: post a tweet into the twitter user timeline
	 */
	function post_tweet($tweet){
		$twitter_obj = new EpiTwitter($this->consumer_key, $this->consumer_secret);
		$twitter_obj->setToken($this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
		if($twitter_obj->post('/statuses/update.json', array('status' => $tweet))){
			return TRUE;
		}
		else{
			return FALSE;
		}	
	}
}
?>