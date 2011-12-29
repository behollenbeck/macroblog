<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('twitter_id');
		echo $this->Form->input('screen_name');
		echo $this->Form->input('oauth_key');
		echo $this->Form->input('oauth_secret');
		echo $this->Form->input('img');
		echo $this->Form->input('location');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('date');
		echo $this->Form->input('Badge');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Badges'), array('controller' => 'badges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Badge'), array('controller' => 'badges', 'action' => 'add')); ?> </li>
	</ul>
</div>
