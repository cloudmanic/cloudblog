<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//

//
// By calling this function and passing an a name a we can
// reference some block content from a view. When we create a 
// block in the control panel we give it a name. We pass that name
// in and this function returns the body of that block.
// If the block is not found it will return blank instead of erroring.
//
if(! function_exists('cb_block'))
{
	function cb_block($name)
	{
		$CI =& get_instance();
		$CI->load->model('cbblocks_model');
		$block = $CI->cbblocks_model->get_by_name($name);
		
		if(isset($block['BlocksBody']))
		{
			return $block['BlocksBody'];
		}
		
		return '';
	}
}

//
// Here we pass in an array and an index.
// If this index not not exist in the array
// we return nothing instead of erroring out.
//
if(! function_exists('data_map'))
{
	function data_map($data, $key)
	{
		if(isset($data[$key]))
		{
			return $data[$key];
		}
		return '';
	}
}

//
// Returns the url for a user to login with google (gmail).
//
if(! function_exists('google_login_link'))
{
	function google_login_link()
	{
		$CI =& get_instance();
		$CI->load->library('cb_login');
		return $CI->cb_login->google_get_login_url();
	}
}

//
// Returns a FQ Url to our static assets
//
if(! function_exists('asset_url'))
{
	function asset_url()
	{
		$CI =& get_instance();
		return $CI->config->item('cb_asset_root');
	}
}

//
// A fancy way to load views in third party packages.
//
if(! function_exists('package_view'))
{
	function package_view($path, $data = array(), $rt = FALSE)
	{
		$CI =& get_instance();
		
		// Load views from third party by changing the view path.
		$orig_view_path = $CI->load->_ci_view_path;
		$CI->load->_ci_view_path = APPPATH . 'third_party/cloudblog/views/';
		
		// Load view
		$v = $CI->load->view($path, $data, $rt);
		
		// Reset the view path
		$CI->load->_ci_view_path = $orig_view_path;
		
		return $v;
	}
}	

//
// This function will return a category selector for posts.
//
if(! function_exists('build_categories_selector'))
{
	function build_categories_selector($postid = NULL)
	{
		$CI =& get_instance();
		$CI->load->model('cbcategories_model');
		$CI->load->model('cbcategoriestoposts_model');
		
		// Setup mapping to figure out if we should check the checkbox or not.
		$map = array();
		if(isset($_POST['Categories']) && is_array($_POST['Categories']))
		{
			foreach($_POST['Categories'] AS $key => $row)
			{
				$map[$row] = $row;
			}
		} else 
		{
			if(! is_null($postid))
			{
				$CI->cbcategoriestoposts_model->set_post($postid);
				if($c = $CI->cbcategoriestoposts_model->get())
				{
					foreach($c AS $key => $row)
					{
						$map[$row['CategoryId']] = $row['CategoryId'];
					}
				}		
			}
		}
		
		// Build Html
		$c = $CI->cbcategories_model->get();
		$html = '<ul>';
		foreach($c AS $key => $row)
		{
			if(isset($map[$row['CategoriesId']]))
				$checked = 'checked=checked';
			else
				$checked = '';
			$html .= '<li>';
			$html .= '<input type="checkbox" name="Categories[]" value="' . $row['CategoriesId'] . '"' .  
										$checked . '/>';
			$html .= $row['CategoriesTitle'];
			$html .= '</li>';
		}
		$html .= '</ul>';
		return $html;
	}
}

//
// This function will return a label selector for managing labels
// that are assocated to a post.
//
if(! function_exists('build_labels_selector'))
{
	function build_labels_selector($postid = NULL)
	{
		$CI =& get_instance();

		$html = '<ul id="mytags">';
		
		// Loop through and show tags. Is this a post with an error state or an update?
		if(isset($_POST['item']['tags']) && is_array($_POST['item']['tags']))
		{
			foreach($_POST['item']['tags'] AS $key => $row)
			{
		  	$html .= '<li>' . $row . '</li>';
			}
		} else if(! is_null($postid))
		{
			$CI->load->model('cblabelstoposts_model');
			$CI->cblabelstoposts_model->add_label_join();
			$CI->cblabelstoposts_model->set_post($postid);
			$labels = $CI->cblabelstoposts_model->get();
			foreach($labels AS $key => $row)
			{
		  	$html .= '<li>' . $row['LabelsTitle'] . '</li>';
			}
		}		
		  
		// Grab the list of tags from the database
		$CI->load->model('cblabels_model');
		$t = $CI->cblabels_model->get();
		$jst = array();
		foreach($t AS $key => $row)
		{
			$jst[] = '"' . $row['LabelsTitle'] . '"';
		}
		$jst = implode(',', $jst);		
		  
		$html .= '</ul>';
		$html .= '<script type="text/javascript">'; 
		$html .= '$(document).ready(function() {';
		$html .= '$("#mytags").tagit({';
		$html .= 'availableTags: [' . $jst . ']';
		$html .= '});';
		$html .= '});';
		$html .= '</script>';
	
		return $html;
	}
}	

/* End File */