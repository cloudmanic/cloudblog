<?=$this->load->view('template/centered-form-header')?>

<?php if(validation_errors()) : ?>
	<?=ui_message_error('Please correct your errors below.')?>
<?php endif; ?>

<?php if($type == 'add') : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . '/blocks/add')?>
<?php else : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . "/blocks/edit/$id")?>
<?php endif; ?>
  <p>
  	<?=form_label('Name:', 'BlocksName')?>
  	<?=form_input('BlocksName', set_value('BlocksName', data_map($data, 'BlocksName')))?>
		<?=form_error('BlocksName', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<?=form_label('Body:', 'BlocksBody')?>
  	<?=form_textarea(array('name' => 'BlocksBody', 'value' => set_value('BlocksBody', data_map($data, 'BlocksBody')), 'cols' => '44', 'rows' => '24'))?>
		<?=form_error('BlocksBody', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<div class="margin-left-300">
  		<button class="button">Save</button> or
  		<a href="<?=$this->config->item('cb_cp_url_base')?>/blocks" class="cancel-link">Cancel</a>
  	</div>
  </p>
  <?=form_hidden('submit', 'submit')?>
<?=form_close()?>
						
<?=$this->load->view('template/centered-form-footer')?>