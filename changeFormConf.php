<?php
include 'mysql.php';
include 'files-manager.php';
include 'form-classes.php';
include 'redirect.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Login_Token']);
    
    $form_name = $_GET['oldTitle'];

    $formTxt = read_form($form_name, $user);
    $form = json_decode($formTxt);

    $form->title = $_GET['title'];
    $form->description = $_GET['description'];
    $form->timed = $_GET['timed'];
    $form->hour = $_GET['hour'];
    $form->date = $_GET['date'];

    $formTxt = json_encode($form);
    save_form($user, $form->title, $formTxt);
    formEdit($form->title);
}
