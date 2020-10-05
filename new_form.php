<?php
include 'mysql.php';
include 'files-manager.php';
include 'form-classes.php';
include 'redirect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = get_email($_COOKIE['Login_Token']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $timed = $_POST['timed'];
    $hour = $_POST['hour'];
    $date = $_POST['date'];

    $form = new form($title, $description, $timed, $hour, $date);

    //JSON ENCODE
    $formTxt = json_encode($form);
    $code = create_form($_POST['title'], $user, $formTxt);
    if ($code == 0) {
        echo $code;
    } else {
        switch ($code) {
            case 301:
                echo 'Já existe um formulário com esse nome.';
                echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                    . "');
            }, 5000);</script>";
                break;
        }
    }
    new_formID($user, $title);
    dashboard();
}
