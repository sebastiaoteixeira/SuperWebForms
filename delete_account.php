<?php
include 'mysql.php';
include 'redirect.php';
include 'files-manager.php';

$user = get_email($_COOKIE['Login_Token']);
delete_account_directory($user);
removeAccountFromDatabase($user);
setcookie("LoginToken", "", time() - 3600);
index(500);
