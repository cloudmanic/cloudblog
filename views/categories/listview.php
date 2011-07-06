<div class="top-bump">
	<div class="left-column">
		<?=$this->load->view('categories/side-bar')?>
		<?=$this->load->view('categories/side-bar-help')?>
	</div>
	
	<div class="right-column">
	<?=ui_widget_start()?>
		<?=ui_widget_header('Categories')?>
		<?=ui_widget_container_start()?>
			<div class="data-header-third">
				<p>
					Below you will find a list of Category names. You may edit or delete any Category. 
				</p>
				<a href="<?=$this->config->item('cb_cp_url_base') . '/categories/add'?>" class="button">Add Category</a>
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
						<td><?=$row['CategoriesTitle']?></td>
						<td>
							<?=anchor($this->config->item('cb_cp_url_base') . '/categories/delete/' . $row['CategoriesId'], 'Delete', 'class="confirm"')?> |
							<?=anchor($this->config->item('cb_cp_url_base') . '/categories/edit/' . $row['CategoriesId'], 'Edit')?>
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