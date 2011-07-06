<div class="top-bump">
	<div class="left-column">
		<?=$this->load->view('posts/side-bar')?>
		<?=$this->load->view('posts/side-bar-help')?>
	</div>
	
	<div class="right-column">
		<?=ui_widget_start()?>
			<?=ui_widget_header('Posts')?>
			<?=ui_widget_container_start()?>
				<div class="data-header-third">
					<p>
						Below you can view and manage different posts.					
					</p>
					<a href="<?=$this->config->item('cb_cp_url_base') . '/posts/add'?>" class="button">New Post</a>
					<br style="clear: both;" />	
				</div>
				
				<table class="data-table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Title</th>
							<th>Status</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($data AS $key => $row) : ?>
						<tr>
							<td><?=date('n/j/Y', strtotime($row['PostsDate']))?></td>
							<td><?=character_limiter($row['PostsTitle'], 60)?></td>
							<td>
							<?php
								if($row['PostsStatus']) echo 'Active'; else echo 'Disabled';
							?>
							</td>
							<td>
								<?=anchor($this->config->item('cb_cp_url_base') . '/posts/delete/' . $row['PostsId'], 'Delete', 'class="confirm"')?> |
								<?=anchor($this->config->item('cb_cp_url_base') . '/posts/edit/' . $row['PostsId'], 'Edit')?> 
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			
			<?=ui_widget_container_end()?>
		<?=ui_widget_end()?>
	</div>
	<br style="clear: both;" />
</div>