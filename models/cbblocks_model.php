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
}

/* End File */