<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//
class cbposts_model extends cbshared_model 
{	
	//
	// Constructor ...
	//
	function __construct()
	{
		parent::__construct();
		$this->_table = 'Posts';
		$this->load->model('cbcategoriestoposts_model');
		$this->load->model('cblabelstoposts_model');
		$this->load->model('cblabelstoposts_model');	
		$this->load->library('typography');
	}

	//
	// Set date range...
	//
	function set_range($start, $stop)
	{
		$this->db->where("PostsDate >= '$start'");
		$this->db->where("PostsDate <= '$stop'");
	}

	//
	// Here we get the post by title.
	//
	function get_by_title_url($title)
	{
 		$this->db->where($this->_table . 'TitleUrl', $title);
		$d = $this->get();
		if(isset($d[0]))
		{
			return $d[0];
		}
		return 0;
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
		$p = $this->db->get($this->_prefix . $this->_table)->result_array();
		$this->_format_posts($p);
		return $p;
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
	// Format your post entries...
	//
	function _format_posts(&$p)
	{
		foreach($p AS $key => $row)
		{
			// Set post urls
			$p[$key]['TitleUrl'] = $this->_blog_base . '/' . $row['PostsTitleUrl'];
			$p[$key]['DateUrl'] = $this->_blog_base . '/' . date('m/d/Y/', strtotime($row['PostsDate'])) . $row['PostsTitleUrl'];
			
			// Add the Categories & Labels to the post
			$p[$key]['Categories'] = $this->cbcategoriestoposts_model->get_formated_post($row['PostsId']);
			$p[$key]['Labels'] = $this->cblabelstoposts_model->get_formated_post($row['PostsId']);
			
			// Format the post
			switch($row['PostsBodyFormat'])
			{
				case '0':
					$p[$key]['FormatedBody'] = $row['PostsBody'];
				break;
				
				case '1':
					$p[$key]['FormatedBody'] = $this->typography->auto_typography($row['PostsBody']);				
				break;
			}
			
			// Format the post summary
			switch($row['PostsSummaryFormat'])
			{
				case '0':
					$p[$key]['FormatedSummary'] = $row['PostsSummary'];
				break;
				
				case '1':
					$p[$key]['FormatedSummary'] = $this->typography->auto_typography($row['PostsSummary']);				
				break;
			}
		}
	}
 	
 	//
 	// Get a list of posts by a particular category and set the having for a post list query.
 	//
 	function set_having_category_name($name)
 	{
		$p = $this->cbcategoriestoposts_model->get_by_category_name_url($name);
		$this->_format_posts($p);
		return $p;
 	}
 	
 	//
 	// Get a list of posts by a particular label and set the having for a post list query.
 	//
 	function set_having_label_name($name)
 	{
		$p = $this->cblabelstoposts_model->get_by_label_name_url($name);
		$this->_format_posts($p);
		return $p;
 	}

	//
	// Return a list of month / year archives.
	//
	function get_archive_month_year_list()
	{
		$sql = "SELECT CONCAT(MONTHNAME(PostsDate), '-', YEAR(PostsDate)) AS Str, MONTHNAME(PostsDate) AS MonthName, 
						YEAR(PostsDate) AS Year, MONTH(PostsDate) AS Month, COUNT(PostsDate) AS Count FROM " . $this->_prefix .
						"Posts GROUP BY Str ORDER BY PostsDate DESC";			
		$archive = $this->db->query($sql)->result_array();
		foreach($archive AS $key => $row)
		{
			$archive[$key]['Url'] = $this->_blog_base . '/' . $this->_archive_trigger . '/' . $row['Year'] . '/' . $row['Month']; 
		}
		
		return $archive;
	}
	
	//
	// Return a list of categories that have been used.
	//
	function get_categories_used()
	{
		$this->db->select('CategoriesTitle, CategoriesTitleUrl, COUNT(CategoriesTitle) AS Count');
		$this->db->join($this->_prefix . 'Categories', 'CategoriesId = CategoryId');
		$this->db->group_by('CategoriesTitle');
		$this->db->order_by('CategoriesTitle');
		$list = $this->db->get($this->_prefix . 'CategoriesToPosts')->result_array();
		
		foreach($list AS $key => $row)
		{
			$list[$key]['Url'] = $this->_blog_base . '/' . $this->_category_trigger . '/' . $row['CategoriesTitleUrl'];
		}
		
		return $list;
	}
}

/* End File */