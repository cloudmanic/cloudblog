<div class="top-bump">
	<div class="left-column">
		<?=$this->load->view('labels/side-bar')?>
		<?=$this->load->view('labels/side-bar-help')?>
	</div>
	
	<div class="right-column">
	<?=ui_widget_start()?>
		<?=ui_widget_header('Labels')?>
		<?=ui_widget_container_start()?>
			<div class="data-header-third">
				<p>
					Below you will find a list of Labels. You may edit or delete any Label. 
				</p>
				<a href="<?=$this->config->item('cb_cp_url_base') . '/labels/add'?>" class="button">Add Label</a>
				<br style="clear: both;" />	
			</div>
			
			<table class="data-table">
				<thead>
					<tr>
						<th>Category Name</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($data AS $key => $row) : ?>
					<tr>
						<td><?=$row['LabelsTitle']?></td>
						<td>
							<?=anchor($this->config->item('cb_cp_url_base') . '/labels/delete/' . $row['LabelsId'], 'Delete', 'class="confirm"')?> |
							<?=anchor($this->config->item('cb_cp_url_base') . '/labels/edit/' . $row['LabelsId'], 'Edit')?>
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