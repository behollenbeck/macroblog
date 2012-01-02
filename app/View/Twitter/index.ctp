<section id='xauth'>
  <h2>xAuth</h2>
  <div id='xauth-login'>
    <?php echo $this->Form->create('Twitter', array('type'=>'POST')); ?>
    <?php echo $this->Form->input('username', array('label'=>'Username')); ?>
    <?php echo $this->Form->input('password', array('label'=>'Password')); ?>
    <?php echo $this->Form->end('login'); ?>
  </div>
</section>

<section id='oauth'>
  <?php echo $this->Html->link('OAuth', Router::url(array('controller'=>'twitter','action'=>'oauth'))); ?>
</section>