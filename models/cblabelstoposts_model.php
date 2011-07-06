<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cblabelstoposts_model extends cbshared_model 
{	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_table = 'LabelsToPosts';	
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
	// Delete by label.
	//
	function delete_by_label($id)
	{
		$this->db->where('LabelId', $id);
		$this->db->delete($this->_prefix . $this->_table);
	}

	//
	// Set the postid for us to look up.
	//
	function set_post($id)
	{
		$this->db->where('PostId', $id);
	}

	//
	// Join in the label names.
	//
	function add_label_join()
	{
		$this->db->join($this->_prefix . 'Labels', 'LabelsId = LabelId');
		$this->db->join($this->_prefix . 'Posts', 'PostId = PostsId');
	}
	
	//
	// Get by label name url.
	//
	function get_by_label_name_url($name)
	{
		$this->add_label_join();
		$this->db->where('LabelsTitleUrl', $name);
		return $this->get();		
	}
	
	//
	// Return a formatted list of categories to attached to a post.
	//
	function get_formated_post($id)
	{
		$this->add_label_join();
		$this->set_order('LabelsTitle');
		$this->set_post($id);
		$d = $this->get();	
		foreach($d AS $key => $row)
		{
			$d[$key]['Url'] = $this->_blog_base . '/' . $this->_label_trigger . '/' . $row['LabelsTitleUrl'];
		}
	
		return $d;
	}
}

/* End File */