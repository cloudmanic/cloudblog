<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cblabels_model extends cbshared_model 
{	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_table = 'Labels';	
	}

	//
	// Look up a Label by name.
	//
	function get_by_name($name)
	{
		$this->db->where(array('LabelsTitle' => $name));
		if($l = $this->get())
		{
			return $l[0];
		}
		return 0;
	}

	//
	// This function will look up the label by name.
	// If the name is not found it will insert the name 
	// Into the labels table. Returns label id.
	//
	function get_insert($name)
	{
		$name = strtolower(trim($name));
		if(! $label = $this->get_by_name($name))
		{
			$id = $this->insert(array('LabelsTitle' => $name,
																'LabelsTitleUrl' => url_title($name)));
		} else
		{
			$id = $label['LabelsId'];
		}
		
		return $id;
	}
}

/* End File */