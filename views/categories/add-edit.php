<?=$this->load->view('template/centered-form-header')?>

<?php if(validation_errors()) : ?>
	<?=ui_message_error('Please correct your errors below.')?>
<?php endif; ?>

<?php if($type == 'add') : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . '/categories/add')?>
<?php else : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . "/categories/edit/$id")?>
<?php endif; ?>
  <p>
  	<?=form_label('Name:', 'CategoriesTitle')?>
  	<?=form_input('CategoriesTitle', set_value('CategoriesTitle', data_map($data, 'CategoriesTitle')))?>
		<?=form_error('CategoriesTitle', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<div class="margin-left-300">
  		<button class="button">Save</button> or
  		<a href="<?=$this->config->item('cb_cp_url_base')?>/categories" class="cancel-link">Cancel</a>
  	</div>
  </p>
  <?=form_hidden('submit', 'submit')?>
<?=form_close()?>
						
<?=$this->load->view('template/centered-form-footer')?>