<?php
include 'form-classes.php';
include 'mysql.php';
include_once 'files-manager.php';
include 'redirect.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Login_Token']);
    
    $form_name = $_GET['form_title'];

    $formTxt = read_form($form_name, $user);
    $form = json_decode($formTxt);

    switch ($_GET['type']) {
        case 'text':
            $newBlock = new textQuestion($_GET['question'], 0, $_GET['rows']);
            break;
    }

    array_push($form->pages[$_GET['page']]->blocks, $newBlock);

    $formTxt = json_encode($form);
    save_form($user, $form->title, $formTxt);
    formEdit($form->title);
}
