

require_once __DIR__ . '/facebook-sdk-5/src/Facebook/autoload.php';
<?php
session_start();
 
require_once 'facebook-php-sdk/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
 
$api_key = '378385452536688';
$api_secret = '64b46eea04b49397e5e4380759f9deae';
$redirect_login_url = 'http://localhost/programmingclub/index.php';
/* PHP SDK v5.0.0 */
/* make the API call */
FacebookSession::setDefaultApplication($api_key, $api_secret);
// create a helper opject which is needed to create a login URL
// the $redirect_login_url is the page a visitor will come to after login
$helper = new FacebookRedirectLoginHelper( $redirect_login_url);


// First check if this is an existing PHP session
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
	// create new session from the existing PHP sesson
	$session = new FacebookSession( $_SESSION['fb_token'] );
	try {
		// validate the access_token to make sure it's still valid
		if ( !$session->validate() ) $session = null;
	} catch ( Exception $e ) {
		// catch any exceptions and set the sesson null
		$session = null;
		echo 'No session: '.$e->getMessage();
	}
}  elseif ( empty( $session ) ) {
	// the session is empty, we create a new one
	try {
		// the visitor is redirected from the login, let's pickup the session
		$session = $helper->getSessionFromRedirect();
	} catch( FacebookRequestException $e ) {
		// Facebook has returned an error
		echo 'Facebook (session) request error: '.$e->getMessage();
	} catch( Exception $e ) {
		// Any other error
		echo 'Other (session) request error: '.$e->getMessage();
	}
}
if ( isset( $session ) ) {
	// store the session token into a PHP session
	$_SESSION['fb_token'] = $session->getToken();
	// and create a new Facebook session using the cururent token
	// or from the new token we got after login
$session = new FacebookSession( $session->getToken() );
$request = new FacebookRequest(
  $session,
  'GET',
  '/{user-id}/picture'
);
$response = $request->execute();
$graphObject = $response->getGraphObject();
}
?>

<html>
<head>
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

/* handle the result */ 
<p>fsdbgisbk</p>
//<img src=$graphObject->data>
</body></html>