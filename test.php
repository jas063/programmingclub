<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '378385452536688',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  
</script>

<?php 

require_once __DIR__ . '/facebook-sdk-5/src/Facebook/autoload.php';
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;

$api_key = '378385452536688';
$api_secret = '64b46eea04b49397e5e4380759f9deae';
$redirect_login_url = 'https://programmingclub.herokuapp.com/';

$fb = new Facebook\Facebook([
  'app_id' => '378385452536688',
  'app_secret' => '64b46eea04b49397e5e4380759f9deae',
  'default_graph_version' => 'v2.8',
]);

$_SESSION['facebook_access_token']=(string)$_GET['session'];
$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
$userid=(string)$_GET['userid'];

$data = [
  'source' => $fb->fileToUpload('images\pr_'.$userid.'.jpeg'),
  ];

$response = $fb->post('/me/photos', $data);
$userNode = $response->getGraphUser();

header('Location: http://www.facebook.com/photo.php?fbid='.$userNode['id'].'&type=1&makeprofile=1');
?>s