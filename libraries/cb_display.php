<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Display
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
		$this->_ci->load->model('cbshared_model');
		
		// Set configs
		$this->_cp_base = $this->_ci->config->item('cb_cp_url_base');
		$this->_table_prefix = $this->_ci->config->item('cb_table_prefix');
	}
	
	//
	// This function will read the url and grab a the post.
	// First it checks for a date formatted url. Then it checks for 
	// just a title formatted url.
	//
	function get_post()
	{
		$this->_ci->load->model('cbposts_model');
		
		// Figure out which title segment to use.
		if($this->_ci->uri->segment($this->_ci->config->item('cb_date_title_segment')))
		{
			$title = $this->_ci->uri->segment($this->_ci->config->item('cb_date_title_segment'));
		} else {
			$title = $this->_ci->uri->segment($this->_ci->config->item('cb_title_segment'));
		}
		
		// Grab the post by title.
		return $this->_ci->cbposts_model->get_by_title_url($title); 
	}
	
	//
	// With this function you can pass in an index array to set params for 
	// returning a list of postings. 
	// Params: limit, offset, order
	//
	function get_posts($params = array())
	{
		$data = array();
		$this->_ci->load->model('cbposts_model');
		
		// Did we pass in a limit / offset?
		if(isset($params['limit']))
		{
			if(isset($params['offset']))
			{
				$this->_ci->cbposts_model->set_limit($params['limit'], $params['offset']);
			} else 
			{
				$this->_ci->cbposts_model->set_limit($params['limit']);
			}
		}
		
		// Did we pass in an order if not set default
		$params['order'] = 'PostsDate DESC';
		if(isset($params['order']))
		{
			$this->_ci->cbposts_model->set_order($params['order']);
		}
		
		// See if this an an archive request.
		if(isset($params['year']) && isset($params['month']))
		{
			$start = $params['year'] . '-' . $params['month'] . '-01';
			$stop = $params['year'] . '-' . $params['month'] . '-31';
			$this->_ci->cbposts_model->set_range($start, $stop);
		}
		
		// Get Posts
		if(isset($params['categoryname']))
		{
			$data['posts'] = $this->_ci->cbposts_model->set_having_category_name($params['categoryname']);
		} else if(isset($params['labelname']))
		{
			$data['posts'] = $this->_ci->cbposts_model->set_having_label_name($params['labelname']);		
		} else 
		{ 	
			$data['posts'] = $this->_ci->cbposts_model->get();
		}
		
		// Add meta data.
		$data['count'] = count($data['posts']);
		$data['total'] = $this->_ci->cbposts_model->total();
		
		return $data;
	}
	
	//
	// This function will return a list of month / year combos. This is used for month/year archives.
	//
	function get_month_year_archive_list()
	{
		$this->_ci->load->model('cbposts_model');
		return $this->_ci->cbposts_model->get_archive_month_year_list();
	}
	
	//
	// This function will return a list of categories used.
	//
	function get_used_categories_list()
	{
		$this->_ci->load->model('cbposts_model');
		return $this->_ci->cbposts_model->get_categories_used();
	}
}

/* End File */