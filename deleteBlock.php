<?php
include 'mysql.php';
include 'files-manager.php';
include 'form-classes.php';
include 'redirect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Login_Token']);
    $formTitle = $_GET['title'];

    $formDataTxt = read_form($formTitle, $user);
    $formData = json_decode($formDataTxt);

    $keyP = $_GET['keyP'];
    $keyB = $_GET['keyB'];
    $page = $formData->pages[$keyP];
    unset($page->blocks[$keyB]);

    $formDataTxt = json_encode($formData);
    save_form($user, $formTitle, $formDataTxt);
    formEdit($formTitle);
}
