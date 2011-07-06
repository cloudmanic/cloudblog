<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
// 
// This is a sample controller for driving the public side of CloudBlog.
// Please replace the "package_view()'s" below with your own views. 
// You will used $this->load->view() instead of "package_view"
//
class Blog extends CI_Controller 
{	
	private $_version = '0.5';
	
	//
	// Constructor ....
	//
	function __construct()
	{
		parent::__construct();
		$data = array();
		$this->load->add_package_path(APPPATH.'third_party/cloudblog/');
		$this->load->library('cb_display');
	}

	//
	// All this controller does it routes requests
	// to the thirdparty package call CloudCms.
	//
	function _remap()
	{
		// Load up sidebar data.
		$data['archive'] = $this->cb_display->get_month_year_archive_list();
		$data['categories'] = $this->cb_display->get_used_categories_list();
	
		// Figure out what to do based on the url.
		switch($this->uri->segment(2))
		{
			case '':
				$data['entries'] = $this->cb_display->get_posts();
				package_view('examples/blog-list', $data); // Replace with your own view file
			break;
			
			case $this->config->item('cb_category_trigger'):
				$data['entries'] = $this->cb_display->get_posts(array('categoryname' => $this->uri->segment(3)));		
				package_view('examples/blog-list', $data); // Replace with your own view file
			break;
			
			case $this->config->item('cb_label_trigger'):
				$data['entries'] = $this->cb_display->get_posts(array('labelname' => $this->uri->segment(3)));		
				package_view('examples/blog-list', $data); // Replace with your own view file
			break;
			
			case $this->config->item('cb_archive_trigger'):
				$data['entries'] = $this->cb_display->get_posts(array('year' => $this->uri->segment(3), 
																															'month' => $this->uri->segment(4)));		
				package_view('examples/blog-list', $data); // Replace with your own view file
			break;
			
			default:
				if(! $data['post'] = $this->cb_display->get_post())
				{
					show_404();
				}			
				package_view('examples/blog-single', $data); // Replace with your own view file
			break;
		}
	}
}

/* End File */