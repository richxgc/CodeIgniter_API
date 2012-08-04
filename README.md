CodeIgniter API
======

Facebook, Twitter and Foursquare PHP Library for CodeIgniter installation

Typical workflow:

1. user click on "login with < insert here your favorite social network >"
	
	-> here enter the function of library or more correct the models, the function in custion is
	get_auth_url
	-> in your controller you have to send this url and show to user in your view
	-> example
	<code>
		$this->load->model('fb');
		$data['fb_login'] = $this->fb->get_auth_url();
		$this->load->view('login',$data);
	</code>

2. get access token and user data here 