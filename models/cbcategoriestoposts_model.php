<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class cbcategoriestoposts_model extends cbshared_model 
{	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_table = 'CategoriesToPosts';	
	}
	
	//
	// Set Join...
	//
	function set_joins()
	{
		$this->db->join($this->_prefix . 'Categories', 'CategoryId = CategoriesId');
		$this->db->join($this->_prefix . 'Posts', 'PostId = PostsId');
	}
	
	//
	// Get by category name url.
	//
	function get_by_category_name_url($name)
	{
		$this->set_joins();
		$this->db->where('CategoriesTitleUrl', $name);
		return $this->get();		
	}
	
	//
	// Return a formatted list of categories to attached to a post.
	//
	function get_formated_post($id)
	{
		$this->set_joins();
		$this->set_order('CategoriesTitle');
		$this->set_post($id);
		$d = $this->get();	
		foreach($d AS $key => $row)
		{
			$d[$key]['Url'] = $this->_blog_base . '/' . $this->_category_trigger . '/' . $row['CategoriesTitleUrl'];
		}
	
		return $d;
	}
	
	//
	// Delete by post.
	//
	function delete_by_post($postid)
	{
		$this->db->where('PostId', $postid);
		$this->db->delete($this->_prefix . $this->_table);
	}

	//
	// Delete by category.
	//
	function delete_by_category($id)
	{
		$this->db->where('CategoryId', $id);
		$this->db->delete($this->_prefix . $this->_table);
	}

	//
	// Set the postid for us to look up.
	//
	function set_post($id)
	{
		$this->db->where('PostId', $id);
	}
}

/* End File */