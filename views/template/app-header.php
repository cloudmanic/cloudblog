<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
		<title><?=$this->config->item('cb_site_name')?></title>
		<meta name="robots" content="noindex,nofollow" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/smoothness/jquery-ui-1.8.13.custom.css" media="screen" /> 
		<link rel="stylesheet" type="text/css" href="<?=asset_url()?>css/dataTables_table_jui.css" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/jquery.tagit.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/base.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/site.css" media="screen" />
				
		<script type="text/javascript"> 
		  var base_url = '<?=base_url()?>';
		  var site_url = '<?=site_url()?>';
		</script> 
		
		<script type="text/javascript" src="<?=asset_url()?>javascript/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>javascript/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>javascript/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>javascript/tag-it.js"></script>
		<script type="text/javascript" src="<?=asset_url()?>javascript/site.js"></script>
	</head>
	<body>
	
	<div id="body-wrapper">
		<div id="header">
			<h1><?=$this->config->item('cb_site_name')?></h1>
			<div id="user-nav">
				Hi, <?=$me['UsersFirstName']?> <?=$me['UsersLastName']?> |
				<?=anchor($this->config->item('cb_cp_url_base') . '/logout', 'Logout')?>
			</div>
			<br style="clear: both;" />
			
			<div id="header-div"></div>
				<?php foreach($mainnav AS $key => $row) : ?>
					<?=anchor($row['url'], $row['name'])?>
					<?php if((count($mainnav) - 1) > $key) : ?> | <?php endif; ?>
				<?php endforeach; ?>
			<div id="header-div"></div>
		</div>