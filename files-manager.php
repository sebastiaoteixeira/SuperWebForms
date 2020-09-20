<?php
define('path', "/path/to/users/forms/");

function create_user_paths($email)
{
    mkdir(path . "users/private/" . $email, 0750);
    mkdir(path . "users/public/" . $email, 0750);
}

function get_filesName($folder_name)
{
    $files = array_merge(scandir(path . 'users/private/' . $folder_name), scandir(path . 'users/public/' . $folder_name));
    foreach ($files as $file) {
        if ($file == "." || $file == "..") {
            unset($files[array_search($file, $files)]);
        }
    }
    return $files;
}

function create_form($title, $user, $content)
{
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '.json', "x");
    echo $file;
    if ($file == false) {
        $errcode = 301;
    } else {
        fwrite($file, $content);
        fclose($file);
        $errcode = 0;
    }
    return $errcode;
}

function read_form($title, $user)
{
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '.json', "r");
    $content = fgets($file);

    fclose($file);
    return $content;

}

function delete_form($file_name, $user)
{
    unlink(path . 'users/private/' . $user . '/' . $file_name);
}

function save_form($user, $title, $new_content)
{
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '.json', "w");
    fwrite($file, $new_content);
    fclose($file);
}
