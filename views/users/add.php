<?=$this->load->view('template/centered-form-header')?>

<?php if(validation_errors()) : ?>
	<?=ui_message_error('Please correct your errors below.')?>
<?php endif; ?>

<?=form_open($this->config->item('cb_cp_url_base') . '/users/add')?>
  <p>
  	<?=form_label('First Name:', 'UsersFirstName')?>
  	<?=form_input('UsersFirstName', set_value('UsersFirstName'))?>
		<?=form_error('UsersFirstName', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<?=form_label('Last Name:', 'UsersLastName')?>
  	<?=form_input('UsersLastName', set_value('UsersLastName'))?>
		<?=form_error('UsersLastName', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<?=form_label('Email:', 'UsersEmail')?>
  	<?=form_input('UsersEmail', set_value('UsersEmail'))?>
		<?=form_error('UsersEmail', '<p class="field-error">', '</p>')?>
  </p>
  
  <p>
  	<div class="margin-left-300">
  		<button class="button">Save</button> or
  		<a href="<?=$this->config->item('cb_cp_url_base')?>/users" class="cancel-link">Cancel</a>
  	</div>
  </p>
  <?=form_hidden('submit', 'submit')?>
<?=form_close()?>
						
<?=$this->load->view('template/centered-form-footer')?>