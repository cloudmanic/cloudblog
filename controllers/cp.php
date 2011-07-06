<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cp extends CI_Controller 
{	
	//
	// All this controller does it routes requests
	// to the thirdparty package call CloudCms.
	//
	function _remap()
	{
		$this->load->add_package_path(APPPATH.'third_party/cloudblog/');
		
		// If the request is empty redirect the user to the login page.
		if($this->uri->segment(2) == '')
		{
			redirect(current_url() . '/login');
		}		

		// If this is a logout request.
		if($this->uri->segment(2) == 'logout')
		{
			$this->load->library('session');
			$this->load->config('cloudblog');
			$this->session->sess_destroy();
			redirect($this->config->item('cb_cp_url_base') . '/login');
		}	
		
		// If we are going to the login page we do not have a session yet.
		if($this->uri->segment(2) == 'login')
		{
			$this->load->library('cb_login');	
		} else
		{
			$this->load->library('cb_controller');
		}
	}
}

/* End File */