<div class="badges view">
<h2><?php  echo __('Badge');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($badge['Badge']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($badge['Badge']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($badge['Badge']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rules'); ?></dt>
		<dd>
			<?php echo h($badge['Badge']['rules']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Badge'), array('action' => 'edit', $badge['Badge']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Badge'), array('action' => 'delete', $badge['Badge']['id']), null, __('Are you sure you want to delete # %s?', $badge['Badge']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Badges'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Badge'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Users');?></h3>
	<?php if (!empty($badge['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Twitter Id'); ?></th>
		<th><?php echo __('Screen Name'); ?></th>
		<th><?php echo __('Oauth Key'); ?></th>
		<th><?php echo __('Oauth Secret'); ?></th>
		<th><?php echo __('Img'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($badge['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['twitter_id'];?></td>
			<td><?php echo $user['screen_name'];?></td>
			<td><?php echo $user['oauth_key'];?></td>
			<td><?php echo $user['oauth_secret'];?></td>
			<td><?php echo $user['img'];?></td>
			<td><?php echo $user['location'];?></td>
			<td><?php echo $user['name'];?></td>
			<td><?php echo $user['description'];?></td>
			<td><?php echo $user['date'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
