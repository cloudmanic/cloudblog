<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Login
{
	private $_ci;
	private $_cp_base;
	private $_table_prefix;
	private $_page_redirect;
	private $_session;
	
	//
	// Constuctor ....
	//
	function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->_data = array();
		
		// Load up helpers, libraries, configs, and models
		$this->_ci->load->config('cloudblog');
		$this->_ci->load->helper('cloudblog');
		$this->_ci->load->model('cbusers_model');
		$this->_ci->load->library('session');
		
		// Set configs
		$this->_cp_base = $this->_ci->config->item('cb_cp_url_base');
		$this->_table_prefix = $this->_ci->config->item('cb_table_prefix');
		$this->_page_redirect = $this->_ci->config->item('cb_login_page'); 
		$this->_session = $this->_ci->config->item('cb_session_name');
		
		// Check for call backs that need to be managed.
		$this->google_check_auth();
		
		// Load login view
		if($this->_ci->uri->segment(2) == 'login')
		{
			// If we already have session redirect to the home page.
			if($this->_sessioncheck())
			{
				redirect($this->_cp_base . '/home');
			}
			
			package_view('login/landing', $this->_ci->_data);
		}
	}
	
	//
	// We call this on every page load. We pass in what types of auths we want for this page.
	// WE pass in an array of group names that are allowed to access this page as well.
	//
	function sessioninit()
	{			
		// Check to see if we have a session.
		if($user = $this->_sessioncheck())
		{
			return $user;
		}
		
		// We are not authenticated we we redirect out of here.
		$this->_ci->session->unset_userdata($this->_session);
		redirect($this->_page_redirect);
		die('no access');
	}
	
	//
	// Session check. This will see if we have a session, and return
	// that session should it exist. 
	//
	private function _sessioncheck()
	{
		// First we change if we have a session already.
		if($user = $this->_ci->session->userdata($this->_session))
		{ 
			if(isset($user['UsersId']))
			{	
				if($dbuser = $this->_ci->cbusers_model->get_by_id($user['UsersId'])) 
				{
					$dbuser['UsersLastActivity'] = $this->_set_last_activity($dbuser['UsersId']);
					$this->_setup_session($dbuser);
											
					return $dbuser;
				}
			}
		}
		
		// Set time stamps.
		$q['UsersLastIn'] = date('Y-m-d G:i:s');
		$q['UsersLastActivity'] = date('Y-m-d G:i:s');
		
		// Check if we have a google oauth callback.
		if($user = $this->_ci->session->userdata('google_auth'))
		{		  
		  $this->_ci->cbusers_model->set_email($user['contact/email']);
		  if($dbuser = $this->_ci->cbusers_model->get())
		  {
		  	$this->_ci->cbusers_model->update($q, $dbuser[0]['UsersId']);
		  } else 
		  {
		  	$this->_ci->session->unset_userdata('google_auth');
		  	redirect($this->_page_redirect);
		  }
		  
		  return $dbuser[0];
		}
		
		return 0;
	}
	
	//
	// This function will log a user out of the system.
	//
	function logout()
	{
		$user = $this->_ci->session->userdata($this->_session);
		$this->_ci->session->sess_destroy();
		redirect($this->_page_redirect);
	}
	
	// ------------- Private Helper Functions ---------- //
	
	//
	// Set last activity for this user.
	//
	private function _set_last_activity($id)
	{
		$q['UsersLastActivity'] = date('Y-m-d G:i:s');
		$this->_ci->cbusers_model->update($q, $id);
		return $q['UsersLastActivity'];
	}
	
	//
	// Setup the session for this users.
	//
	private function _setup_session($dbuser)
	{		
		$this->_ci->session->set_userdata($this->_session, $dbuser);
	}
	
	// ------------- Google Functions ------------------ //
	
	//
	// With google all the info comes back via a GET. We check to see if we have that information.
	// We then store it in a session and redirect.
	//
	function google_check_auth()
	{
		if($this->_ci->input->get('openid_mode'))
		{
			if($this->_ci->input->get('openid_mode') != 'cancel')
			{
				$this->_ci->load->library('openid');
				if($this->_ci->openid->validate()) 
				{
					$this->_ci->session->set_userdata('google_auth', $this->_ci->openid->getAttributes());
					redirect(current_url());
				}
			}
		}
	}
	
	//
	// Setup and load the Google libraries. After this the system can do google auth.
	//
	function google_load()
	{
		$this->_ci->load->library('openid');
		$this->_ci->openid->identity = 'https://www.google.com/accounts/o8/id';
		$this->_ci->openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
		return 0;	
	}
	
	//
	// Returns the url for a user to login.
	//
	function google_get_login_url()
	{
		$this->google_load();
		return $this->_ci->openid->authUrl();
	}
}

/* End File */