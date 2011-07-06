<?=$this->load->view('template/big-centered-form-header')?>

<?php if(validation_errors()) : ?>
	<?=ui_message_error('Please correct your errors below.')?>
<?php endif; ?>

<?php if($type == 'add') : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . '/posts/add')?>
<?php else : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . "/posts/edit/$id")?>
<?php endif; ?>
	<p>
		<div style="float: left;">
			<?=form_label('Date:', 'PostsDate')?>
			<?=form_input('PostsDate', set_value('PostsDate', data_map($data, 'PostsDate')), 'class="datepicker"')?>
			<?=form_error('PostsDate', '<p class="field-error">', '</p>')?>	
		</div>
		
		<div style="float: right;">
			<?=form_label('Status:', 'PostsStatus')?>
			<?=form_dropdown('PostsStatus', array('1' => 'Active', '0' => 'Disabled'), 
												set_value('PostsStatus', data_map($data, 'PostsStatus')))?>
			<?=form_error('PostsStatus', '<p class="field-error">', '</p>')?>			
		</div>
		<br style="clear:both;" />
	</p>
	
  <p>
  	<?=form_label('Title:', 'PostsTitle')?>
  	<?=form_input('PostsTitle', set_value('PostsTitle', data_map($data, 'PostsTitle')))?>
		<?=form_error('PostsTitle', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<?=form_label('Body:', 'PostsBody')?>
  	<?=form_textarea(array('name' => 'PostsBody', 'value' => set_value('PostsBody', data_map($data, 'PostsBody')), 'cols' => '79', 'rows' => '24'))?>
  	<div class="field-footer-left">
			<?=form_error('PostsBody', '<p class="field-error">', '</p>')?>
  	</div>
  	<div class="field-footer-right">
  		<span>Formatting: </span>
			<?=form_dropdown('PostsBodyFormat', array('1' => 'Auto', '0' => 'None'), 
												set_value('PostsBodyFormat', data_map($data, 'PostsBodyFormat')))?>
		</div>
		<br style="clear:both;" />
  </p>

	<?php if(in_array('summary', $sections)) : ?>
  <p>
  	<?=form_label('Summary:', 'PostsSummary')?>
  	<?=form_textarea(array('name' => 'PostsSummary', 'value' => set_value('PostsSummary', data_map($data, 'PostsSummary')), 'cols' => '79', 'rows' => '10'))?>
		<div class="field-footer-left">
 			<p class="cb-field-helper-text">Short summary often used for post listing pages.</p>
			<?=form_error('PostsSummary', '<p class="field-error">', '</p>')?>
		</div>
  	<div class="field-footer-right">
  		<span>Formatting: </span>
			<?=form_dropdown('PostsSummaryFormat', array('1' => 'Auto', '0' => 'None'), 
												set_value('PostsSummaryFormat', data_map($data, 'PostsSummaryFormat')))?>
		</div>
		<br style="clear:both;" />
  </p>
  <?php endif; ?>  
 
	<?php if(in_array('description', $sections)) : ?>
  <p>
  	<?=form_label('Description:', 'PostsDescription')?>
  	<?=form_input('PostsDescription', set_value('PostsDescription', data_map($data, 'PostsDescription')))?>
  	<p class="cb-field-helper-text">Short description often put in the HTML header.</p>
		<?=form_error('PostsDescription', '<p class="field-error">', '</p>')?>
  </p>
	<?php endif; ?>
  
	<?php if(in_array('keywords', $sections)) : ?>
  <p>
  	<?=form_label('Keywords:', 'PostsKeywords')?>
  	<?=form_input('PostsKeywords', set_value('PostsKeywords', data_map($data, 'PostsKeywords')))?>
		<p class="cb-field-helper-text">CSV list of keywords. (ie.keyword #1, keyword #2, .....)</p>
		<?=form_error('PostsKeywords', '<p class="field-error">', '</p>')?>
  </p>
	<?php endif; ?>
  
	<?php if(in_array('categories', $sections)) : ?>
  <p>
  	<?=form_label('Categories:', 'Categories[]')?>
		<?php if($type == 'add') : ?>
  		<?=build_categories_selector()?>
  	<?php else : ?>
  		<?=build_categories_selector($data['PostsId'])?>  	
  	<?php endif; ?>
		<?=form_error('Categories', '<p class="field-error">', '</p>')?>
  </p>
	<?php endif; ?>
  
	<?php if(in_array('labels', $sections)) : ?>
  <p>
		<span class="tag-span"><?=form_label('Labels:', 'mytags')?></span>
		<?php if($type == 'add') : ?>
  		<?=build_labels_selector()?>
  	<?php else : ?>
  		<?=build_labels_selector($data['PostsId'])?>  	
  	<?php endif; ?>
  	<br style="clear: both;" />
  </p>
	<?php endif; ?>
	
  <p>
  	<div class="margin-left-300">
  		<button class="button">Save</button> or
  		<a href="<?=$this->config->item('cb_cp_url_base')?>/posts" class="cancel-link">Cancel</a>
  	</div>
  </p>
  <?=form_hidden('submit', 'submit')?>
<?=form_close()?>
						
<?=$this->load->view('template/big-centered-form-footer')?>