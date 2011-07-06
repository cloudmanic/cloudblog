<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title></title>
		<style type="text/css">
		 .left-col { float: right; width: 250px; margin-left: 15px; }
		 .right-col { float: right; width: 650px; }
		</style>
	</head>
	<body>
		<div class="left-col">
			<h2>Archives</h2>
			<?php foreach($archive AS $key => $row) : ?>
			<a href="<?=$row['Url']?>"><?=$row['MonthName']?> - <?=$row['Year']?> (<?=$row['Count']?>)</a><br />
			<?php endforeach; ?>
			
			<h2>Categories</h2>
			<?php foreach($categories AS $key => $row) : ?>
			<a href="<?=$row['Url']?>"><?=$row['CategoriesTitle']?> (<?=$row['Count']?>)</a><br />
			<?php endforeach; ?>
		</div>
		
		<div class="right-col">
			<div class="post">
				<h3><a href="<?=$post['DateUrl']?>"><?=$post['PostsTitle']?></a></h3>
				<div class="post-header">
					<p><b>Date:</b> <?=date('n/j/Y', strtotime($post['PostsDate']))?></p>
					<p>
						<b>Categories:</b> 
						<?php $links = array(); foreach($post['Categories'] AS $key => $row) : ?>
							<?php $links[] = '<a href="' . $row['Url'] . '">' . $row['CategoriesTitle'] . '</a>'; ?>
						<?php endforeach; ?>
						<?=implode(' | ', $links)?>
					</p>
				</div>
				<?=$post['FormatedBody']?>
				<div class="post-footer">
					<p>
						<b>Labels:</b> 
						<?php $links = array(); foreach($post['Labels'] AS $key => $row) : ?>
							<?php $links[] = '<a href="' . $row['Url'] . '">' . $row['LabelsTitle'] . '</a>'; ?>
						<?php endforeach; ?>
						<?=implode(' | ', $links)?>
					</p>
				</div>
				<div class="comment-body">
					<p>Here you would put your commenting systems. We suggest <a href="http://disqus.com">Disqus</a></p>
				</div>
			</div>
		</div>
	</body>
</html>
