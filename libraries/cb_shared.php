<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Shared
{
	protected $_ci;
	protected $_action;
	
	//
	// Constructor ...
	//
	function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->_data['data'] = array();
		$this->_action = $this->_ci->uri->segment(2);
	}
	
	//
	// Route request....
	//
	function _route_request()
	{
		// Route the URL request
		switch($this->_ci->uri->segment(3))
		{
			case 'edit': $this->_edit(); break;
			case 'add': $this->_add(); break;
			case 'delete': $this->_delete(); break;
			case '': $this->_listview(); break;
			default: show_404(); break;
		}
	}
	
	//
	// Generic listview....
	//
	function _listview()
	{
		$this->_ci->load->model('cb' . $this->_action . '_model');
		$this->_ci->_data['data'] = $this->_ci->{'cb' . $this->_action . '_model'}->get();
		package_view('template/app-header', $this->_ci->_data);
		package_view($this->_action . '/listview', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);
	}
	
	//
	// Generic delete operations.
	//
	function _delete()
	{
		$this->_ci->load->model('cb' . $this->_action . '_model');
		$this->_ci->{'cb' . $this->_action . '_model'}->delete($this->_ci->uri->segment(4));
		redirect($this->_ci->config->item('cb_cp_url_base') . '/' . $this->_action);
	}
}