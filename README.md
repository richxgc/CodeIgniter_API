CodeIgniter API
======

<h4>Facebook, Twitter and Foursquare PHP Library for CodeIgniter installation.</h4>

<p>Typical workflow:</p>

<p>1. User click on "login with [insert here your favorite social network]" here comes the function of library get_auth_url(). In your controller you have to send this url and show it to user in your view, example:</p>

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

<p>2. After user allow your application you have the respective tokens, with this tokens you have acces to user data, to get this data you have to call get_user() function, in twitter case you will have to call set_access_token() function after token request (aka login action).</p>
<p>Note: you may have configure the callback url at your application controll panel, this url must be your controller function that has to process the respective query information, in facebook case the callback url is in fb model.</p>

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

<p>Of preference you should save tokens on your database, the procedure would look like this:</p>

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

<p>3. Use this data at your convenience :)</p>

<h3>Licence</h3>
<h5>CodeIgniter API Library is under MIT Licence</h5>

<p>The MIT License (MIT)</p>
<p>Copyright © 2012, @grcardo</p>

<p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>

<p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>

<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>