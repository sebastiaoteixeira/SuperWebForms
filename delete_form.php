<?php
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Session_ID']);
    delete_form($_GET['name'], $user);
    dashboard();
}
