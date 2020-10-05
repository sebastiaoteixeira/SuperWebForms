<?php
define('url', 'http://dominio');

function dashboard()
{
    header("Location: " . url . "/dashboard.php");
    echo '2';
    die();
}

function formEdit($title)
{
    header("Location: " . url . "/formEdit.php?title=" . $title);
    die();
}
