<?php
include 'form-classes.php';
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Session_ID']);

    $form_name = $_GET['form_title'];

    $formTxt = read_form($form_name, $user);
    $form = json_decode($formTxt);

    switch($_GET['type']){
        case 'text':
            $newBlock = new textQuestion($_GET['question'], 0,0);
            break;
    }

    echo var_dump($form);
    echo '<br>';

    array_push($form->blocks, $newBlock);
    echo var_dump($form);
    $formTxt = json_encode($form);
    save_form($user, $form->title, $formTxt);
    form($form->title);
}