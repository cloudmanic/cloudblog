<?=$this->load->view('template/centered-form-header')?>

<?php if(validation_errors()) : ?>
	<?=ui_message_error('Please correct your errors below.')?>
<?php endif; ?>

<?php if($type == 'add') : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . '/labels/add')?>
<?php else : ?>
	<?=form_open($this->config->item('cb_cp_url_base') . "/labels/edit/$id")?>
<?php endif; ?>
  <p>
  	<?=form_label('Name:', 'LabelsTitle')?>
  	<?=form_input('LabelsTitle', set_value('LabelsTitle', data_map($data, 'LabelsTitle')))?>
		<?=form_error('LabelsTitle', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<div class="margin-left-300">
  		<button class="button">Save</button> or
  		<a href="<?=$this->config->item('cb_cp_url_base')?>/labels" class="cancel-link">Cancel</a>
  	</div>
  </p>
  <?=form_hidden('submit', 'submit')?>
<?=form_close()?>
						
<?=$this->load->view('template/centered-form-footer')?>