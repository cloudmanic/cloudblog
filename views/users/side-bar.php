<?php
$seg = $this->uri->segment(3);
$base = $this->config->item('cb_cp_url_base');
?>

<?=ui_widget_start()?>
  <?=ui_widget_header('Manage')?>
  <?=ui_widget_container_start()?>
		<ul>
			<li>
				<a href="<?=$base?>/users" class="<?php if($seg == '') { echo 'side-active'; } ?>">List Users</a>
			</li>
			<li>
				<a href="<?=$base?>/users/add" class="<?php if($seg == 'add') { echo 'side-active'; } ?>">New User</a>
			</li>
		</ul>
  <?=ui_widget_container_end()?>
<?=ui_widget_end()?>