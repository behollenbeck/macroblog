<section id='update-status'>
  <?php echo $this->Form->create(null,array('action'=>'sendTweet', 'type'=>'POST')); ?>
  <?php echo $this->Form->textarea('status'); ?>
  <?php echo $this->Form->end('Tweet'); ?>
</section>
<section id='tweets'>
  <?php if( isset($timeline) && !empty($timeline) ) : ?>
    <ul>
    <?php foreach( $timeline as $tweet ) : ?>
      <li><strong><?php echo $tweet->user->name; ?>(@<?php echo $tweet->user->screen_name; ?>):</strong> <?php echo $tweet->text; ?></li>
    <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p><?php __('Sorry, there are no tweets at this time'); ?></p>
  <?php endif; ?>
</section>