<div class="top-bump">
	<div class="left-column">
		<?=$this->load->view('blocks/side-bar')?>
		<?=$this->load->view('blocks/side-bar-help')?>
	</div>
	
	<div class="right-column">
	<?=ui_widget_start()?>
		<?=ui_widget_header('Blocks')?>
		<?=ui_widget_container_start()?>
			<div class="data-header-third">
				<p>
					Below you will find a list of Blocks. You may edit or delete any Block. 
				</p>
				<a href="<?=$this->config->item('cb_cp_url_base') . '/blocks/add'?>" class="button">Add Block</a>
				<br style="clear: both;" />	
			</div>
			
			<table class="data-table">
				<thead>
					<tr>
						<th>Name</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($data AS $key => $row) : ?>
					<tr>
						<td><?=$row['BlocksName']?></td>
						<td>
							<?=anchor($this->config->item('cb_cp_url_base') . '/blocks/delete/' . $row['BlocksId'], 'Delete', 'class="confirm"')?> |
							<?=anchor($this->config->item('cb_cp_url_base') . '/blocks/edit/' . $row['BlocksId'], 'Edit')?>
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