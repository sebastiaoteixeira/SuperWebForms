<?php
include 'form-classes.php';
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Session_ID']);
    $formTitle = $_GET['title'];

    $formDataTxt = read_form($formTitle, $user);
    $formData = json_decode($formDataTxt);

    $key = $_GET['key'];
    unset($formData->blocks[$key]);

    $formDataTxt = json_encode($formData);
    save_form($user, $formTitle, $formDataTxt);
    form($formTitle);
}
