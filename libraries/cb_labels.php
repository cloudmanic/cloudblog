<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Labels extends CB_Shared
{
	//
	// Constuctor ....
	//
	function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('cblabels_model');
		$this->_route_request();
	}
	
	//
	// Add a post ...
	//
	function _add()
	{
		$this->_ci->_data['widgettext'] = 'Add New Label';
		$this->_ci->_data['helpertext'] = 'To add a new label fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'add';
		
		$this->_add_edit_shared_func();	
	}

	//
	// Edit a post ...
	//
	function _edit()
	{
		$this->_ci->_data['widgettext'] = 'Edit Label';
		$this->_ci->_data['helpertext'] = 'To edit this label fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'edit';
		
		// Get data
		$this->_ci->_data['id'] = $id = $this->_ci->uri->segment(4);
		if(! $this->_ci->_data['data'] = $this->_ci->cblabels_model->get_by_id($id)) 
		{
			redirect($this->_ci->config->item('cb_cp_url_base') . '/categories');
		}	
		
		$this->_add_edit_shared_func($id);	
	}
	
	//
	// Delete operations.
	//
	function _delete()
	{
		// Toast the loop up table entries first.
		$this->_ci->load->model('cblabelstoposts_model');
		$this->_ci->cblabelstoposts_model->delete_by_label($this->_ci->uri->segment(4));
		
		parent::_delete();
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
			$this->_ci->form_validation->set_rules('LabelsTitle', 'Name', 'required|trim');
	
			if($this->_ci->form_validation->run() != FALSE)
			{
				$q['LabelsTitle'] = $this->_ci->input->post('LabelsTitle');
				$q['LabelsTitleUrl'] = url_title(strtolower($q['LabelsTitle']));
				
				if($update)
				{
					$this->_ci->cblabels_model->update($q, $update);
				} else
				{
					$this->_ci->cblabels_model->insert($q);
				}
				
				redirect($this->_ci->config->item('cb_cp_url_base') . '/labels');
			}
		}
		
		package_view('template/app-header', $this->_ci->_data);
		package_view('labels/add-edit', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);
	}
}

/* End File */