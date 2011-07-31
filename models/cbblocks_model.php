<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cbblocks_model extends cbshared_model 
{	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_table = 'Blocks';	
	}
	
	//
	// Return the contents of a block by the block name.
	//
	function get_by_name($name)
	{
 		$this->db->where($this->_table . 'Name', $name);
		return $this->db->get($this->_prefix . $this->_table)->row_array();
	} 
}

/* End File */