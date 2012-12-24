<?php
    session_start();

    $config['base_url']             =   'http://www.startuplist.sg/media/startuplist/linkedin/auth.php';
    $config['callback_url']         =   'http://www.startuplist.sg';
    $config['linkedin_access']      =   'ivfdie7hflz3';
    $config['linkedin_secret']      =   'SQ7Tp9Vxf2i5KDsz';

    include_once "linkedin.php";
   
    
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
    //$linkedin->debug = true;

   if (isset($_REQUEST['oauth_verifier'])){
        $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->getAccessToken($_REQUEST['oauth_verifier']);

        $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
        header("Location: " . $config['callback_url']);
        exit;
   }
   else{
        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
   }


    # You now have a $linkedin->access_token and can make calls on behalf of the current member
    $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url)");

    echo '<pre>';
    echo 'My Profile Info';
    echo $xml_response;
    echo '<br />';
    echo '</pre>';
	
?>