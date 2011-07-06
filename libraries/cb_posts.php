<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Posts
{
	private $_ci;

	//
	// Constuctor ....
	//
	function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->_data['data'] = array();
		$this->_ci->load->model('cbposts_model');
		$this->_ci->load->helper('text');
		$this->_ci->_data['sections'] = $this->_ci->config->item('cb_post_sections');
		
		// Route the URL request
		switch($this->_ci->uri->segment(3))
		{
			case 'add': $this->_add(); break;
			case 'edit': $this->_edit(); break;
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
		$this->_ci->load->model('cbposts_model');
		$this->_ci->_data['data'] = $this->_ci->cbposts_model->get();
		package_view('template/app-header', $this->_ci->_data);
		package_view('posts/listview', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);	
	}
	
	//
	// Add a post ...
	//
	private function _add()
	{
		$this->_ci->_data['widgettext'] = 'Add New Post';
		$this->_ci->_data['helpertext'] = 'To add a post fill out the fields below and click "save"';
		$this->_ci->_data['type'] = 'add';
		$this->_ci->_data['data']['PostsDate'] = date('m/d/Y');
		$this->_ci->_data['data']['PostsStatus'] = 1;
		
		$this->_add_edit_shared_func();	
	}

	//
	// Edit a post ...
	//
	private function _edit()
	{
		$this->_ci->_data['widgettext'] = 'Edit Post';
		$this->_ci->_data['helpertext'] = 'To edit this post fill out the fields below and click "save"';
		$this->_ci->_data['type'] = 'edit';
		
		// Get data
		$this->_ci->_data['id'] = $id = $this->_ci->uri->segment(4);
		if(! $this->_ci->_data['data'] = $this->_ci->cbposts_model->get_by_id($id)) 
		{
			redirect($this->_ci->config->item('cb_cp_url_base') . '/posts');
		}	
		
		// Date formatting
		$this->_ci->_data['data']['PostsDate'] = date('m/d/Y', strtotime($this->_ci->_data['data']['PostsDate'])); 
		
		$this->_add_edit_shared_func($id);	
	}

	//
	// Delete a user from the system.
	//
	private function _delete()
	{
		$this->_ci->load->model('cbposts_model');
		$this->_ci->load->model('cblabelstoposts_model');
		$this->_ci->cbposts_model->delete($this->_ci->uri->segment(4));
		$this->_ci->cblabelstoposts_model->delete_by_post($this->_ci->uri->segment(4));
		redirect($this->_ci->config->item('cb_cp_url_base') . '/posts');
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
			$this->_ci->form_validation->set_rules('PostsTitle', 'Title', 'required|trim');
			$this->_ci->form_validation->set_rules('PostsBody', 'Body', 'required|trim');
			$this->_ci->form_validation->set_rules('PostsSummary', 'Summary', 'trim');
			$this->_ci->form_validation->set_rules('PostsDate', 'Date', 'trim');
			$this->_ci->form_validation->set_rules('PostsStatus', 'Status', 'trim');
			$this->_ci->form_validation->set_rules('PostsBodyFormat', 'Body Format', 'trim');
			$this->_ci->form_validation->set_rules('PostsSummaryFormat', 'Summary Format', 'trim');
			$this->_ci->form_validation->set_rules('PostsDescription', 'Description', 'trim');
			$this->_ci->form_validation->set_rules('PostsKeywords', 'Keywords', 'trim');
			
			if($this->_ci->form_validation->run() != FALSE)
			{
				$q['PostsUserId'] = $this->_ci->_data['me']['UsersId'];
				$q['PostsTitle'] = $this->_ci->input->post('PostsTitle');
				$q['PostsTitleUrl'] = url_title(strtolower($q['PostsTitle']));
				$q['PostsBody'] = $this->_ci->input->post('PostsBody');
				$q['PostsSummary'] = $this->_ci->input->post('PostsSummary');
				$q['PostsDescription'] = $this->_ci->input->post('PostsDescription');
				$q['PostsKeywords'] = $this->_ci->input->post('PostsKeywords');
				$q['PostsStatus'] = $this->_ci->input->post('PostsStatus');
				$q['PostsDate'] = date('Y-n-j', strtotime($_POST['PostsDate']));
				$q['PostsBodyFormat'] = $this->_ci->input->post('PostsBodyFormat');
				$q['PostsSummaryFormat'] = $this->_ci->input->post('PostsSummaryFormat');
				
				// Insert or update the post.
				if($update)
				{
					$this->_ci->cbposts_model->update($q, $update);
					$postid = $update;
				} else
				{
					$postid = $this->_ci->cbposts_model->insert($q);
				}
				
				// Deal with labels
				$this->_ci->load->model('cblabels_model');
				$this->_ci->load->model('cblabelstoposts_model');
				$this->_ci->cblabelstoposts_model->delete_by_post($postid);
				if(isset($_POST['item']['tags']) && is_array($_POST['item']['tags']))
				{	
					// Loop through each label. Add to label table then add to look up table. 
					foreach($_POST['item']['tags'] AS $key => $row)
					{
						$lid = $this->_ci->cblabels_model->get_insert($row);
						$this->_ci->cblabelstoposts_model->insert(array('LabelId' => $lid, 
																														'PostId' => $postid));	
					}
				}
				
				// Deal with categories 
				$this->_ci->load->model('cbcategoriestoposts_model');
				$this->_ci->cbcategoriestoposts_model->delete_by_post($postid);
				if(isset($_POST['Categories']) && is_array($_POST['Categories']))
				{
					foreach($_POST['Categories'] AS $key => $row)
					{
						$this->_ci->cbcategoriestoposts_model->insert(array('CategoryId' => $row, 
																																'PostId' => $postid));	
					}
				}
				
				redirect($this->_ci->config->item('cb_cp_url_base') . '/posts');
			}
		}

		package_view('template/app-header', $this->_ci->_data);
		package_view('posts/add-edit', $this->_ci->_data);
		package_view('template/app-footer', $this->_ci->_data);
	}
}

/* End File */