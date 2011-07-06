<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cbshared_model extends CI_Model 
{
	protected $_table = '';
	protected $_prefix = '';
	protected $_blog_base = '';
	protected $_category_trigger = '';
	protected $_label_trigger = '';
	protected $_archive_trigger = '';
	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_prefix = $this->config->item('cb_table_prefix');
		$this->_blog_base = $this->config->item('cb_blog_url_base');
		$this->_category_trigger = $this->config->item('cb_category_trigger');
		$this->_label_trigger = $this->config->item('cb_label_trigger');
		$this->_archive_trigger = $this->config->item('cb_archive_trigger');	
	}
	
 	//
 	// This function will set the query order.
 	//
 	function set_order($order)
 	{
 		$this->db->order_by($order);	
 	}
	
	//
 	// This function will set the query limit.
 	//
 	function set_limit($limit, $offset = 0)
 	{
 		$this->db->limit($limit, $offset);	
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
	// Get all the users in the system.
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
 	
	//
	// Returns the total number of rows found.
	//
	function total()
	{
		return $this->db->count_all_results($this->_prefix . $this->_table);
	}
}

/* End File */