<?php

$config['Twitter'] = array(
  'consumer_key'    => 'aySRI2TrW0X6BWvcnPJPw',
  'consumer_secret' => '78r8gtFhaAL2O9GgCATR1ef0krbbrAUrqWUatmJGyc',
);

$config['Twitter']['api_url'] = array(
  'request_token' => 'https://api.twitter.com/oauth/request_token',
  'authorize'     => 'https://api.twitter.com/oauth/authorize',
  'access_token'  => 'https://api.twitter.com/oauth/access_token',
  'base_url'      => 'https://api.twitter.com/1/'
);

$config['Twitter']['functions'] = array(
  'timeline'      => 'statuses/home_timeline',
  'tweet'         => 'statuses/update',
  // add more functions as needed
);

$config['Twitter']['format'] = 'json';

/* End of File : twitter.php */
?>