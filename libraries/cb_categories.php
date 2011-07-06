<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Categories extends CB_Shared
{
	//
	// Constuctor ....
	//
	function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('cbcategories_model');
		$this->_route_request();
	}
	
	//
	// Add a post ...
	//
	function _add()
	{
		$this->_ci->_data['widgettext'] = 'Add New Category';
		$this->_ci->_data['helpertext'] = 'To add a new category fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'add';
		
		$this->_add_edit_shared_func();	
	}

	//
	// Edit a post ...
	//
	function _edit()
	{
		$this->_ci->_data['widgettext'] = 'Edit Category';
		$this->_ci->_data['helpertext'] = 'To edit this category fill out the field below and click "save"';
		$this->_ci->_data['type'] = 'edit';
		
		// Get data
		$this->_ci->_data['id'] = $id = $this->_ci->uri->segment(4);
		if(! $this->_ci->_data['data'] = $this->_ci->cbcategories_model->get_by_id($id)) 
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
		$this->_ci->load->model('cbcategoriestoposts_model');
		$this->_ci->cbcategoriestoposts_model->delete_by_category($this->_ci->uri->segment(4));
		
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
			$this->_ci->form_validation->set_rules('CategoriesTitle', 'Name', 'required|trim');
	
			if($this->_ci->form_validation->run() != FALSE)
			{
				$q['CategoriesTitle'] = $this->_ci->input->post('CategoriesTitle');
				$q['CategoriesTitleUrl'] = url_title(strtolower($q['CategoriesTitle']));
				
				if($update)
				{
					$this->_ci->cbcategories_model->update($q, $update);
				} else
				{
					$this->_ci->cbcategories_model->insert($q);
				}
				
				redirect($this->_ci->config->item('cb_cp_url_base') . '/categories');
			}
		}
		
		package_view('template/app-header', $this->_ci->_data);
		package_view('categories/add-edit', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);
	}
}

/* End File */