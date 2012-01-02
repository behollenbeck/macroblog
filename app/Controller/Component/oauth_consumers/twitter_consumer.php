<?php

 class TwitterConsumer extends AbstractConsumer {
    
     public function __construct() {
        
        parent::__construct(Configure::read('Twitter.consumer_key'), Configure::read('Twitter.consumer_secret'));
    
    }
 }
?>
