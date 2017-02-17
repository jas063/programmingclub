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
  session_start();
 require_once __DIR__ . '/facebook-sdk-5/src/Facebook/autoload.php';

use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;

$api_key = '378385452536688';
$api_secret = '64b46eea04b49397e5e4380759f9deae';
$redirect_login_url = 'http://localhost/programmingclub/index1.php';

$fb = new Facebook\Facebook([
  'app_id' => '378385452536688',
  'app_secret' => '64b46eea04b49397e5e4380759f9deae',
  'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('https://programmingclub.herokuapp.com/', $permissions);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,picture.width(400).height(400)');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
try{
  $user = $response->getGraphUser();
$src = imagecreatefrompng('clublogo.png');
$dest = imagecreatefromjpeg($user['picture']["url"]);

imagecopymerge($dest, $src, 380, 380, 0, 0, 100, 100,80); //have to play with these numbers for it to work for you, etc.

$path='pr_'.$userNode["id"].'.jpeg';
$userid=$userNode['id'];
imagejpeg($dest, $path);

imagedestroy($dest);
imagedestroy($src);


$session=$_SESSION['facebook_access_token'];
$data = [
  'source' => $fb->fileToUpload('pr_'.$userNode['id'].'.jpeg'),
  ];

$response = $fb->post('/me/photos', $data);
$userNode = $response->getGraphUser();
} catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
  exit;
}
$url='http://www.facebook.com/photo.php?fbid='.$userNode['id'].'&type=1&makeprofile=1';

echo '<a href="' . $url . '">Make profile pic!</a>';
echo '<img src = "pr_'.$userid.'.jpeg" widht=300px height=400px></img>';
}
else {
  // we need to create a new session, provide a login link
  echo 'No session, please <a href="'. $loginUrl.'">login</a>.';
}
?>
</body>
</html>
