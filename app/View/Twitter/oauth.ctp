<?php if( isset($error) && $error ) : ?>
<section id='error'>
  <p><?php __('Could not connect to Twitter at this time'); ?></p>
</section>
<?php else : ?>
<section id='message'>
  <p><?php __('You will be redirected to Twitter OAuth Authorization in '); ?><span id='counter'>10</span><?php __(' seconds'); ?></p>
</section>
<script>
  window.onload = function() {
    setTimeout(function(){
      window.location.href = "<?php echo Configure::read('Twitter.api_url.authorize'); ?>?oauth_token=<?php echo $requestToken->key; ?>";
    }, 10000);
  }
</script>
<?php endif; ?>