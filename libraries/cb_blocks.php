<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Blocks extends CB_Shared
{
	//
	// Constuctor ....
	//
	function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('cbblocks_model');
		$this->_route_request();
	}
	
	//
	// Add a post ...
	//
	function _add()
	{
		$this->_ci->_data['widgettext'] = 'Add New Block';
		$this->_ci->_data['helpertext'] = 'To add a new block fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'add';
		
		$this->_add_edit_shared_func();	
	}

	//
	// Edit a post ...
	//
	function _edit()
	{
		$this->_ci->_data['widgettext'] = 'Edit Block';
		$this->_ci->_data['helpertext'] = 'To edit this block fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'edit';
		
		// Get data
		$this->_ci->_data['id'] = $id = $this->_ci->uri->segment(4);
		if(! $this->_ci->_data['data'] = $this->_ci->cbblocks_model->get_by_id($id)) 
		{
			redirect($this->_ci->config->item('cb_cp_url_base') . '/blocks');
		}	
		
		$this->_add_edit_shared_func($id);	
	}
	
	// ------------------ Internal Helper Functions ---------------- //
	
	//
	// Shared functionality between add / edit.
	//
	private function _add_edit_shared_func($update = FALSE)
	{
		// Manage posted data.
		if($this->_ci->input->post('submit'))
		{
			$this->_ci->load->library('form_validation');
			$this->_ci->form_validation->set_rules('BlocksName', 'Name', 'required|trim|strtolower');
			$this->_ci->form_validation->set_rules('BlocksBody', 'Body', 'required|trim');
	
			if($this->_ci->form_validation->run() != FALSE)
			{
				$q['BlocksName'] = $this->_ci->input->post('BlocksName');
				$q['BlocksBody'] = $this->_ci->input->post('BlocksBody');
				
				if($update)
				{
					$this->_ci->cbblocks_model->update($q, $update);
				} else
				{
					$this->_ci->cbblocks_model->insert($q);
				}
				
				redirect($this->_ci->config->item('cb_cp_url_base') . '/blocks');
			}
		}
		
		package_view('template/app-header', $this->_ci->_data);
		package_view('blocks/add-edit', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);
	}
}

/* End File */