<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Users
{
	private $_ci;

	//
	// Constuctor ....
	//
	function __construct()
	{
		$this->_ci =& get_instance();
		
		// Route the URL request
		switch($this->_ci->uri->segment(3))
		{
			case 'add': $this->_add(); break;
			case 'delete': $this->_delete(); break;
			case '': $this->_listview(); break;
			default: show_404(); break;
		}
	}
	
	//
	// Listview page ...
	//
	private function _listview()
	{
		$this->_ci->load->model('cbusers_model');
		$this->_ci->_data['users'] = $this->_ci->cbusers_model->get();
		package_view('template/app-header', $this->_ci->_data);
		package_view('users/listview', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);	
	}
	
	//
	// Add a user ...
	//
	private function _add()
	{
		$this->_ci->_data['widgettext'] = 'Add New User';
		$this->_ci->_data['helpertext'] = 'To add a user enter their information below and click "save"';
		
		// Manage posted data.
		if($this->_ci->input->post('submit'))
		{
			$this->_ci->load->library('form_validation');
			$this->_ci->form_validation->set_rules('UsersFirstName', 'First Name', 'required|trim');
			$this->_ci->form_validation->set_rules('UsersLastName', 'Last Name', 'required|trim');
			$this->_ci->form_validation->set_rules('UsersEmail', 'Email', 'required|valid_email|trim');
	
			if($this->_ci->form_validation->run() != FALSE)
			{
				$q['UsersFirstName'] = $this->_ci->input->post('UsersFirstName');
				$q['UsersLastName'] = $this->_ci->input->post('UsersLastName');
				$q['UsersEmail'] = $this->_ci->input->post('UsersEmail');
				$this->_ci->load->model('cbusers_model');
				$this->_ci->cbusers_model->insert($q);
				redirect($this->_ci->config->item('cb_cp_url_base') . '/users');
			}
		}
		
		package_view('template/app-header', $this->_ci->_data);
		package_view('users/add', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);		
	}

	//
	// Delete a user from the system.
	//
	private function _delete()
	{
		$this->_ci->load->model('cbusers_model');
		$this->_ci->cbusers_model->delete($this->_ci->uri->segment(4));
		redirect($this->_ci->config->item('cb_cp_url_base') . '/users');
	}
}

/* End File */