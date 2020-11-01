<?php

require_once('vendor/autoload.php');
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';
include_once 'config.php';

$client = new Google\Client();
$client->setAuthConfig(googleOAuthKeyJson);

$client->setApplicationName('SuperWebForms');
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));

$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/registerWithGoogle.php');
$client->setAccessType('offline');        // offline access
$client->setIncludeGrantedScopes(true);   // incremental auth



if($_GET['code'] != null){
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();

    $jwt = explode('.', $access_token['id_token']);
    
    $userinfo_coded = $jwt[1];
    $userinfo = json_decode(base64_decode($userinfo_coded), true);

    $name=$userinfo['name'];
    $email=$userinfo['email'];
    sendToDatabase($email, $name, null, time(), true);
    
    $id = create_session($email, $remember);
    setcookie('Login_Token', $id, 0, '/');

    create_user_paths($email);
    dashboard();    
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . $auth_url);
    die();
}
