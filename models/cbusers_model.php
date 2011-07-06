<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cbusers_model extends CI_Model 
{
	private $_table = 'Users';
	private $_prefix = '';
	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_prefix = $this->config->item('cb_table_prefix');	
	}
	
	//
	// Set email...
	//
	function set_email($email)
	{
		$this->db->where($this->_table . 'Email', $email);
	}

 	//
 	// This function will return by id.
 	//
 	function get_by_id($id)
 	{
 		$this->db->where($this->_table . 'Id', $id);
		return $this->db->get($this->_prefix . $this->_table)->row_array();
 	}
	
	//
	// Get all the posts in the system.
	//
	function get()
	{
		return $this->db->get($this->_prefix . $this->_table)->result_array();
	}
	
 	//
 	// This function will take the data passed in and update it in the table by id.
 	//
 	function update($data, $id)
 	{		
 		$this->db->where($this->_table . 'Id', $id);
 		$this->db->update($this->_prefix . $this->_table, $data);
 	}
	
 	//
 	// This function will take the data passed in and insert it into the table
 	//
 	function insert($data)
 	{ 	
 		if(! isset($data[$this->_table . 'CreatedAt']))
 		{
 			$data[$this->_table . 'CreatedAt'] = date('Y-m-d G:i:s');
 		}
 		
 		$this->db->insert($this->_prefix . $this->_table, $data);
		$id = $this->db->insert_id();
		
		return $id;
 	}
	
 	//
 	// This function will a delete by id.
 	//
 	function delete($id)
 	{
 		$this->db->where($this->_table . 'Id', $id);
 		$this->db->delete($this->_prefix . $this->_table); 
 	}
}

/* End File */