<section id='response'>
  <p><?php __('Twitter authorization complete, proceeding to application...'); ?></p>
</section>
<script>
  window.onload = function() {
    setTimeout(function(){
      window.location.href = "<?php Router::url(array('controller'=>'twitter','action'=>'viewTweets')); ?>";
    }, 200);
  }
</script>
