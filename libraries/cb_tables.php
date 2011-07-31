<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class CB_Tables
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
		$this->_ci->load->helper('jquery-ui');
		$this->_ci->load->library('cb_shared');
		$this->_ci->load->model('cbshared_model');
		$this->_ci->load->library('cb_login');
		$this->_ci->load->library('cb_tables');
		
		// Set configs
		$this->_cp_base = $this->_ci->config->item('cb_cp_url_base');
		$this->_table_prefix = $this->_ci->config->item('cb_table_prefix');
		$this->_page_redirect = $this->_ci->config->item('cb_login_page'); 
		$this->_session = $this->_ci->config->item('cb_session_name');
		
		// Make sure all the proper tables are installed.
		$this->_table_check();
	}
	
	// ----------------- Manage All The DB Tables --------------------- //
	
	//
	// Check to see we have all tables installed properly.
	//
	private function _table_check()
	{
		$this->_users_check();
		$this->_posts_check();
		$this->_blocks_check();
		$this->_categories_check();
		$this->_labels_check();
	}
	
	//
	// Build the users table if it is not installed already.
	//
	private function _users_check()
	{	
		// Setup Users Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'Users')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'UsersId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'UsersFirstName' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersLastName' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersEmail' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersDisplayName' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => FALSE),
				'UsersUrl' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE),
				'UsersImage' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE),
				'UsersLastIn' => array('type' => 'DATETIME', 'null' => FALSE),
				'UsersLastActivity' => array('type' => 'DATETIME', 'null' => FALSE)
			);
			
			$this->_ci->dbforge->add_key('UsersId', TRUE);
			$this->_ci->dbforge->add_key('UsersEmail');
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("UsersUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("UsersCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'Users', TRUE);
		}
	}
	
	//
	// Build the posts table if it is not installed already.
	//
	private function _posts_check()
	{	
		// Setup Posts Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'Posts')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'PostsId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'PostsUserId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE),				
				'PostsTitle' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'PostsTitleUrl' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE),
				'PostsSummary' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'PostsDescription' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'PostsBody' => array('type' => 'TEXT', 'null' => FALSE),
				'PostsKeywords' => array('type' => 'TEXT', 'null' => FALSE),
				'PostsStatus' => array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 1),
				'PostsBodyFormat' => array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 1),
				'PostsSummaryFormat' => array('type' => 'TINYINT', 'constraint' => 1, 'unsigned' => TRUE, 'default' => 1),
				'PostsDate' => array('type' => 'DATE', 'null' => FALSE)
			);
			
			$this->_ci->dbforge->add_key('PostsId', TRUE);
			$this->_ci->dbforge->add_key('PostsTitleUrl');
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("PostsUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("PostsCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'Posts', TRUE);
		}
	}

	//
	// Build the blocks table if it is not installed already.
	//
	private function _blocks_check()
	{	
		// Setup Blocks Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'Blocks')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'BlocksId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),			
				'BlocksName' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'BlocksBody' => array('type' => 'TEXT', 'null' => FALSE)
			);
			
			$this->_ci->dbforge->add_key('BlocksId', TRUE);
			$this->_ci->dbforge->add_key('BlocksName');
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("BlocksUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("BlocksCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'Blocks', TRUE);
		}
	}

	//
	// Build the Labels table if it is not installed already.
	//
	private function _labels_check()
	{	
		// Setup Categories Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'Labels')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'LabelsId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),				
				'LabelsTitle' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'LabelsTitleUrl' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE)
			);
			
			$this->_ci->dbforge->add_key('LabelsId', TRUE);
			$this->_ci->dbforge->add_key('LabelsTitleUrl');
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("LabelsUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("LabelsCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'Labels', TRUE);
		}
		
		// Setup LabelsToPost Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'LabelsToPosts')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'LabelId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE),				
				'PostId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE)
			);
			
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("LabelsToPostsUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("LabelsToPostsCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'LabelsToPosts', TRUE);
		}
	}	
	
	//
	// Build the Categories table if it is not installed already.
	//
	private function _categories_check()
	{	
		// Setup Categories Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'Categories')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'CategoriesId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),				
				'CategoriesTitle' => array('type' => 'VARCHAR', 'constraint' => '500', 'null' => FALSE),
				'CategoriesTitleUrl' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => FALSE)
			);
			
			$this->_ci->dbforge->add_key('CategoriesId', TRUE);
			$this->_ci->dbforge->add_key('CategoriesTitleUrl');
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("CategoriesUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("CategoriesCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'Categories', TRUE);
		}
		
		// Setup CategoriesToPost Table
		if(! $this->_ci->db->table_exists($this->_table_prefix . 'CategoriesToPosts')) 
		{
			$this->_ci->load->dbforge();
			
			$cols = array(
				'CategoryId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE),				
				'PostId' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE)
			);
			
    	$this->_ci->dbforge->add_field($cols);
    	$this->_ci->dbforge->add_field("CategoriesToPostsUpdatedAt TIMESTAMP DEFAULT now() ON UPDATE now()");
    	$this->_ci->dbforge->add_field("CategoriesToPostsCreatedAt TIMESTAMP DEFAULT '0000-00-00 00:00:00'");
    	$this->_ci->dbforge->create_table($this->_table_prefix . 'CategoriesToPosts', TRUE);
		}
	}	
}

/* End File */