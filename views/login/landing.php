<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
		<title>Admins Only</title>
		<meta name="robots" content="noindex,nofollow" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/smoothness/jquery-ui-1.8.13.custom.css" media="screen" /> 
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/base.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?=asset_url()?>css/site.css" media="screen" />
				
		<script type="text/javascript"> 
		  var asset_url = '<?=asset_url()?>';
		  var site_url = '<?=site_url()?>';
		</script> 
		
		<script type="text/javascript" src="<?=asset_url()?>javascript/jquery-1.5.1.min.js" charset="UTF-8"></script>
		<script type="text/javascript" src="<?=asset_url()?>javascript/jquery-ui-1.8.13.custom.min.js" charset="UTF-8"></script>
	</head>
	<body>
		<div class="login-cont">
			<h1><?=$this->config->item('cb_logintitle')?></h1>
			<a href="<?=google_login_link()?>">
				<img src="<?=asset_url()?>images/google-btn.png" alt="Click Here To Login With Google" />
			</a>
		</div>
	</body>
</html>