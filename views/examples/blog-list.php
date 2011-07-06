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
			<?php foreach($entries['posts'] AS $key => $row) : ?>
			<div class="post">
				<h3><a href="<?=$row['DateUrl']?>"><?=$row['PostsTitle']?></a></h3>
				<div class="post-header">
					<p><b>Date:</b> <?=date('n/j/Y', strtotime($row['PostsDate']))?></p>
					<p>
						<b>Categories:</b> 
						<?php $links = array(); foreach($row['Categories'] AS $key2 => $row2) : ?>
							<?php $links[] = '<a href="' . $row2['Url'] . '">' . $row2['CategoriesTitle'] . '</a>'; ?>
						<?php endforeach; ?>
						<?=implode(' | ', $links)?>
					</p>
				</div>
				<?=$row['FormatedSummary']?>
				<a href="<?=$row['TitleUrl']?>">Read More...</a>
				<div class="post-footer">
					<p>
						<b>Labels:</b> 
						<?php $links = array(); foreach($row['Labels'] AS $key2 => $row2) : ?>
							<?php $links[] = '<a href="' . $row2['Url'] . '">' . $row2['LabelsTitle'] . '</a>'; ?>
						<?php endforeach; ?>
						<?=implode(' | ', $links)?>
					</p>
				</div>
			</div>
			<?php endforeach; ?>
			
			<?php if(count($entries['posts']) <= 0) : ?>
			<h2>No Posts Found</h2>
			<?php endif; ?>
		</div>
	</body>
</html>
