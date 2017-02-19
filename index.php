<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' type='text/css'>
	<link rel="stylesheet" href="maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<style type="text/css">
.facebook{
  background: #3B5998; 
  padding: 0.5em;
  color: #fff;
  text-decoration: none;
  margin-left: 10px;
  border-radius: 5px;

}
	</style>
</head>
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
$redirect_login_url = 'http://phpfbapp-myproj3.rhcloud.com/';
echo "fdsgsdg";
$fb = new Facebook\Facebook([
  'app_id' => '378385452536688',
  'app_secret' => '64b46eea04b49397e5e4380759f9deae',
  'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://phpfbapp-myproj3.rhcloud.com/', $permissions);

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
echo "vsdsdbf ";
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
echo "vfdsvs ";
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
echo "cdsgvs ";
try{
	
  $user = $response->getGraphUser();
$src = imagecreatefrompng('images\clublogo.png');
echo "  1  ";
$dest = imagecreatefromjpeg($user['picture']["url"]);
echo "  2  ";
imagecopymerge($dest, $src, 380, 380, 0, 0, 100, 100,80); //have to play with these numbers for it to work for you, etc.
echo "  3  ";
$path='images\pr_'.$userNode["id"].'.jpeg';
$userid=$userNode['id'];
imagejpeg($dest, $path);
echo "    4  ";
imagedestroy($dest);
imagedestroy($src);

echo '<img src = "images\pr_'.$userid.'.jpeg" widht=300px height=400px></img>';
$session=$_SESSION['facebook_access_token'];
$userid=$userNode['id'];
echo '<a class="facebook" href="test.php?session='.$session.'&userid='.$userid.'"><i class="fa fa-facebook-square"></i>Make profile picture</a>';


}catch(Exception $e) {
	echo 'Message: ' .$e->getMessage();
    exit;
}}
else {
  // we need to create a new session, provide a login link
  echo 'No session, please <a href="'. $loginUrl.'">login</a>.';
}
?>

</body>
</html>

