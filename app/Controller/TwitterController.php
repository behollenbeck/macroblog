<?php

/**
 * Demo controller for showing how to use the Twitter OAuth Consumer component
 * @author JA Clarke
 */
class TwitterController extends AppController
{
  var $uses = null;
  var $components = array('OauthConsumer');
  
  function beforeFilter() {
    parent::beforeFilter();
    
    Configure::load('sitesettings');
    Configure::load('twitter');
    
    if( $this->Session->check('Twitter.access_token') ) {
      $this->set('logged_in', true);
    }
  }
  
  function index() {
    if( $this->Session->check('Twitter.access_token') ) { // First check if there is a previous active session still
      $this->redirect(Router::url(array('controller'=>'twitter', 'action'=>'viewTweets')));
    }
    
    $this->render('index');
  }
  
  function oauth() {
    $requestToken = '';
    
    if( $requestToken = $this->OauthConsumer->getRequestToken('Twitter', Configure::read('Twitter.api_url.request_token'), $this->_localUrl(Router::url(array('controller'=>'twitter','action'=>'callback')))) ) {
      $this->Session->write('Twitter.request_token', $requestToken);
    } else {
      $this->set('error',true);
    }
    
    $this->set(compact('requestToken'));
  }
  
  function callback() {
    if( $this->Session->check('Twitter.access_token') ) { // First check if there is a previous active session still
      $this->redirect(Router::url(array('controller'=>'twitter', 'action'=>'viewTweets')));
    }
    
    if( $this->Session->check('Twitter.request_token') ) { // Check if this was a actual request and not URL trolling ;)
      $requestToken = $this->Session->read('Twitter.request_token');
      // $this->Session->delete('Twitter.request_token');
      
      $accessToken = $this->OauthConsumer->getAccessToken('Twitter', Configure::read('Twitter.api_url.access_token'), $requestToken);
      $this->Session->write('Twitter.access_token', $accessToken);
      $this->redirect(Router::url(array('controller'=>'twitter','action'=>'viewTweets')));
      
    } else {
      $this->Session->setFlash('Unable to process request', 'default', array('class'=>'warning'));
      $this->redirect(Router::url(array('controller'=>'twitter','action'=>'index')));
    }
  }
  
  function sendTweet() {
    if( $this->Session->check('Twitter.access_token') && $this->data ) {
      $accessToken = $this->Session->read('Twitter.access_token');
      
      if( $this->OauthConsumer->post('Twitter', $accessToken->key, $accessToken->secret, $this->_twitterUrl('tweet'), array('status'=>$this->data['status'])) ) {
        $this->Session->setFlash('Tweet successfully published', 'default', array('class'=>'success'));
      } else {
        $this->Session->setFlash('Tweet was not published', 'default', array('class'=>'warning'));
      }
      $this->redirect(Router::url(array('controller'=>'twitter','action'=>'viewTweets')));
    } else {
      $this->Session->setFlash('Please authenticate first', 'default', array('class'=>'error'));
      $this->Session->redirect(Router::url(array('controller'=>'twitter','action'=>'index')));
    }
  }
  
  function viewTweets() {
    if( $this->Session->check('Twitter.access_token') ) {
      $accessToken = $this->Session->read('Twitter.access_token');
      
      // Load the tweets from the user's timeline
      $count = Configure::read('SiteSetting.number_of_tweets');
      if( $timeline = $this->OauthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, $this->_twitterUrl('timeline'), compact('count')) ) {
        $timeline = json_decode($timeline);
      }      
      $this->set(compact('timeline'));
      $this->render('view_tweets');
    } else {
      $this->Session->setFlash('Please authenticate first', 'default', array('class'=>'error'));
      $this->redirect(Router::url(array('controller'=>'twitter','action'=>'index')));
    }
  }
  
  function logout() {
    $this->Session->delete('Twitter');
    $this->redirect(Router::url(array('controller'=>'twitter','action'=>'index')));
  }
  
  private function _twitterUrl($method = 'timeline') {
    return Configure::read('Twitter.api_url.base_url') . Configure::read('Twitter.functions.'.$method) . '.' . Configure::read('Twitter.format');
  }
  
  private function _localUrl($route) {
    return 'http://' . $_SERVER['HTTP_HOST'] . $route;
  }
}

/* End of File: twitter_controller.php */
?>
