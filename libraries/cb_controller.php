<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Controller
{
	private $_version = '0.5';
	private $_ci;
	private $_cp_base;
	private $_table_prefix;
	
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
		$this->_ci->load->helper('jquery-ui');
		$this->_ci->load->library('cb_shared');
		$this->_ci->load->model('cbshared_model');
		$this->_ci->load->library('cb_login');
		$this->_ci->load->library('cb_tables');
		
		// Set configs
		$this->_cp_base = $this->_ci->config->item('cb_cp_url_base');
		$this->_table_prefix = $this->_ci->config->item('cb_table_prefix');
		
		// Set Main Navigation
		$this->_ci->_data['mainnav'][] = array('url' => $this->_cp_base . '/posts', 'name' => 'Posts');
		$this->_ci->_data['mainnav'][] = array('url' => $this->_cp_base  . '/blocks', 'name' => 'Blocks');
		$this->_ci->_data['mainnav'][] = array('url' => $this->_cp_base  . '/categories', 'name' => 'Categories');
		$this->_ci->_data['mainnav'][] = array('url' => $this->_cp_base  . '/labels', 'name' => 'Labels');
		$this->_ci->_data['mainnav'][] = array('url' => $this->_cp_base  . '/users', 'name' => 'Users');
		
		// Route request
		if(! $this->_check_login_page())
		{
			$this->_route_request();
		}
	}
	
	//
	// Read the request and send it to the correct funtion to manage it.
	//
	private function _route_request()
	{
		// If we are logged in redirect to the home page.
		$this->_ci->_data['me'] = $this->_ci->cb_login->sessioninit();
				
		$controller = $this->_ci->uri->segment(2);
		switch($controller)
		{
			case 'home': 
				// We redirect here because some day we will have a landing dashboard.
				redirect($this->_cp_base . '/posts');
			break;
			
			case 'posts': 
				$this->_ci->load->library('cb_posts'); 
			break;

			case 'blocks': 
				$this->_ci->load->library('cb_blocks');
			break;
			
			case 'categories': 
				$this->_ci->load->library('cb_categories');
			break;

			case 'labels': 
				$this->_ci->load->library('cb_labels');
			break;
			
			case 'users': 
				$this->_ci->load->library('cb_users');
			break;
			
			default: show_404(); break;
		}
	}
	
	// -------------------- Private Helper Functions -------------------- //
	
	//
	// Check to see if this is a login request.
	//
	private function _check_login_page()
	{
		if($this->_ci->uri->segment(2) == 'login')
		{
			package_view('login/landing', $this->_ci->_data);
			return true;
		}
		
		if($this->_ci->uri->segment(2) == '')
		{
			redirect($this->_cp_base . '/login');
			return true;
		}
		return false;
	}
}

/* End File */