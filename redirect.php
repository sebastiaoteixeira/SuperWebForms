<?php
define('url', 'http://url');

function dashboard()
{
    header("Location: " . url . "/dashboard.php");
    die();
}

function form($title)
{
    header("Location: " . url . "/form.php?title=" . $title);
    die();
}
