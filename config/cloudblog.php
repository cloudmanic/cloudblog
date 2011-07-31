<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//

// General Settings 
$config['cb_asset_root'] = site_url() . 'cloudblog/'; // trailing slash
$config['cb_logintitle'] = 'CloudBlog Login // Admins Only';
$config['cb_blog_url_base'] = site_url('/blog');
$config['cb_cp_url_base'] = site_url('/cp');
$config['cb_table_prefix'] = 'CB_';
$config['cb_site_name'] = 'CloudBlog';
$config['cb_post_sections'] = array('summary', 'description', 'keywords', 'categories', 'labels');

// URL Settings
$config['cb_category_trigger'] = 'category';
$config['cb_label_trigger'] = 'label';
$config['cb_archive_trigger'] = 'archive';
$config['cb_feed_trigger'] = 'feed';
$config['cb_date_title_segment'] = '5';
$config['cb_title_segment'] = '2';

// Authentication Settings
$config['cb_session_name'] = 'cloudblogs';
$config['cb_login_page'] = $config['cb_cp_url_base'] . '/login';


/* End File */