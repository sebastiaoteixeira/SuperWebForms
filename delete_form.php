<?php
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Login_Token']);
    delete_form($_GET['name'], $user);
    removeFormID($_GET['name'], $user);
    dashboard();
}
