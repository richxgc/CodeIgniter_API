CodeIgniter API
======

<h4>Facebook, Twitter and Foursquare PHP Library for CodeIgniter installation.</h4>

<p>Typical workflow:</p>

<p>1. user click on "login with [insert here your favorite social network]" here comes the function of library get_auth_url(). In your controller you have to send this url and show it to user in your view, example:</p>

<pre>
<code>
//facebook login url
$this->load->model('fb');
$data['fb_login'] = $this->fb->get_auth_url();

//twitter login url
$this->load->model('tw');
$data['tw_login'] = $this->tw->get_auth_url();

//load view
$this->load->view('login',$data);
</code>
</pre>

<p>then user click on link like this:</p>
<pre>
<code>
	//login view
	<a href="<?php echo $fb_login;?>">Login with Facebook</a>
	<a href="<?php echo $tw_login;?>">Login with Twitter</a>
</code>
</pre>

<p>2. after user allow your application you have the respective tokens with this tokens you have acces to user data, to get this data you have to call function get_user(), in twitter case you have to call function set_access_token() after token request (aka login action).</p>
<p>Note: you may have configure the callback url at your application controll panel, this url must be your controller function that has to process the respective query information</p>

<pre>
<code>
//facebook controller
$this->load->model('fb');
$fb_user = $this->fb->get_user();
echo $fb_user['name'];

//twitter controller
$this->load->model('tw');
$this->tw->set_access_token();
$tw_user = $this->tw->get_user();
echo $tw_user->username;
</code>
</pre>

<p>of preference you should save tokens on your database, the procedure would look like this:</p>

<pre>
<code>
//facebook controller
$this->load->model('fb');
$access_token = $this->fb->get_access_token();
$fb_user = $this->fb->get_user();
//save token and user facebook id on database
$this->db->set('facebookid',$fb_user['id']);
$this->db->set('access_token',$access_token);
$this->db->insert('users');

//twitter controller
$this->load->model('tw');
$this->tw->set_access_token();
$oauth_token = $this->session->userdata('oauth_token');
$oauth_token_secret = $this->session->userdata('oauth_token_secret');
$tw_user = $this->tw->get_user();
//save token and user twitter id on database
$this->db->set('twitterid',$tw_user->id);
$this->db->set('oauth_token',$oauth_tokne);
$this->db->set('oauth_token_secret',$oauth_token_secret);
$this->db->insert('users');
</code>
</pre>