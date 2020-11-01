<?php

// This example shows how to have your users log in via Patreon, and acquire access and refresh tokens after logging in

include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';
include_once 'config.php';
require_once 'vendor/autoload.php';
 
use Patreon\API;
use Patreon\OAuth;


$redirect_uri = url . '/registerWithPatreon.php'; // Replace http://mydomain.com/patreon_login with the url at your site which is going to receive users returning from Patreon confirmation

// Generate the oAuth url

$href = 'https://www.patreon.com/oauth2/authorize?response_type=code&client_id=' . patreon_client_id . '&redirect_uri=' . urlencode($redirect_uri);

// You can send an array of vars to Patreon and receive them back as they are. Ie, state vars to set the user state, app state or any other info which should be sent back and forth.

$state = array();
 
// For example lets set final page which the user needs to land at - this may be a content the user is unlocking via oauth, or a welcome/thank you page

// Lets make it a thank you page

$state['final_page'] = url; // Replace http://mydomain.com/thank_you with the url that has your thank you page

// Add any number of vars you need to this array by $state['YOURKEY'] = VARIABLE

// Prepare state var. It must be json_encoded, base64_encoded and url encoded to be safe in regard to any odd chars
$state_parameters = '&state=' . urlencode( base64_encode( json_encode( $state ) ) );

// Append it to the url

$href .= $state_parameters;

// Now place the url into a login link. Below is a very simple login link with just text. in assets/images folder, there is a button image made with official Patreon assets (login_with_patreon.png). You can also use this image as the inner html of the <a> tag instead of the text provided here

// Scopes! You must request the scopes you need to have the access token.
// In this case, we are requesting the user's identity (basic user info), user's email
// For example, if you do not request email scope while logging the user in, later you wont be able to get user's email via /identity endpoint when fetching the user details
// You can only have access to data identified with the scopes you asked. Read more at https://docs.patreon.com/#scopes

// Lets request identity of the user, and email.

$scope_parameters = '&scope=identity%20identity'.urlencode('[email]');

$href .= $scope_parameters;

// Simply echoing it here. You can present the login link/button in any other way.

header('Location: ' . $href);


if ( $_GET['code'] != '' ) {
	echo '<br>';
	$oauth_client = new OAuth(patreon_client_id, patreon_client_secret);	

	$tokens = $oauth_client->get_tokens($_GET['code'], $redirect_uri);
	
	$access_token = $tokens['access_token'];
	$refresh_token = $tokens['refresh_token'];
	



	$api_client = new Patreon\API($access_token);
	$response = $api_client->fetch_user();
	$name = $response['data']['attributes']['full_name'];
	$email = $response['data']['attributes']['email'];
	sendToDatabase($email, $name, null, time(), true);
	
	$id = create_session($email, $remember);
        setcookie('Login_Token', $id, 0, '/');
        create_user_paths($email);
        dashboard();
}
