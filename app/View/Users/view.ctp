<div class="users view">
<h2><?php  echo __('User');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Twitter Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['twitter_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Screen Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['screen_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oauth Key'); ?></dt>
		<dd>
			<?php echo h($user['User']['oauth_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Oauth Secret'); ?></dt>
		<dd>
			<?php echo h($user['User']['oauth_secret']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Img'); ?></dt>
		<dd>
			<?php echo h($user['User']['img']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($user['User']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($user['User']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($user['User']['date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Badges'), array('controller' => 'badges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Badge'), array('controller' => 'badges', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Posts');?></h3>
	<?php if (!empty($user['Post'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Content'); ?></th>
		<th><?php echo __('Length'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Post'] as $post): ?>
		<tr>
			<td><?php echo $post['id'];?></td>
			<td><?php echo $post['user_id'];?></td>
			<td><?php echo $post['title'];?></td>
			<td><?php echo $post['content'];?></td>
			<td><?php echo $post['length'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), null, __('Are you sure you want to delete # %s?', $post['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Badges');?></h3>
	<?php if (!empty($user['Badge'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Rules'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Badge'] as $badge): ?>
		<tr>
			<td><?php echo $badge['id'];?></td>
			<td><?php echo $badge['name'];?></td>
			<td><?php echo $badge['description'];?></td>
			<td><?php echo $badge['rules'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'badges', 'action' => 'view', $badge['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'badges', 'action' => 'edit', $badge['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'badges', 'action' => 'delete', $badge['id']), null, __('Are you sure you want to delete # %s?', $badge['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Badge'), array('controller' => 'badges', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
