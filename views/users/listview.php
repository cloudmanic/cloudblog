<div class="top-bump">
	<div class="left-column">
		<?=$this->load->view('users/side-bar')?>
		<?=$this->load->view('users/side-bar-help')?>
	</div>
	
	<div class="right-column">
	<?=ui_widget_start()?>
		<?=ui_widget_header('Users')?>
		<?=ui_widget_container_start()?>
			<div class="data-header-third">
				<p>
					To manage a user you maintain their name, and email. When they authenticate to the site
					with the matching email they are granted access. 
				</p>
				<a href="<?=$this->config->item('cb_cp_url_base') . '/users/add'?>" class="button">Add User</a>
				<br style="clear: both;" />	
			</div>
			
			<table class="data-table">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Last Activity</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach($users AS $key => $row) : ?>
					<tr>
						<td><?=$row['UsersFirstName']?></td>
						<td><?=$row['UsersLastName']?></td>
						<td><?=$row['UsersEmail']?></td>
						<td>
							<?php if($row['UsersLastActivity'] != '0000-00-00 00:00:00') : ?>
								<?=date('n/j/Y G:i a', strtotime($row['UsersLastActivity']))?>
							<?php else : ?>
								Never
							<?php endif; ?>
						</td>
						<td>
							<?php if($me['UsersId'] != $row['UsersId']) : ?>
								<?=anchor($this->config->item('cb_cp_url_base') . '/users/delete/' . $row['UsersId'], 'Delete', 'class="confirm"')?>
							<?php endif; ?> 
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