<?php
define('path', "/path/to/site/");

function create_user_paths($email)
{
    mkdir(path . "users/private/" . $email, 0750);
    mkdir(path . "users/public/" . $email, 0750);
}

function get_filesName($folder_name)
{
    $files = scandir(path . 'users/private/' . $folder_name);
    foreach ($files as $file) {
        if ($file == "." || $file == "..") {
            unset($files[array_search($file, $files)]);
        }
    }
    return $files;
}

function create_form($title, $user, $content)
{
    mkdir(path . 'users/private/' . $user . '/' . $title);
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $title . '.json', "x");
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
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $title . '.json', "r");
    $content = fgets($file);

    fclose($file);
    return $content;
}

function read_response($title, $response_name, $user)
{
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $response_name . '.json', "r");
    $content = fgets($file);

    fclose($file);
    return $content;
}

function delete_form($file_name, $user)
{
    $files = scandir(path . 'users/private/' . $user . '/' . $file_name);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = path . 'users/private/' . $user . '/' . $file_name . '/' . $file;
            is_dir($filePath) ? delete_form($file, $user) : unlink($filePath);
        }
    }
    rmdir(path . 'users/private/' . $user . '/' . $file_name);

    return;
}

function delete_account_directory($user)
{
    $files = scandir(path . 'users/private/' . $user);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = path . 'users/private/' . $user . '/' . $file_name . '/' . $file;
            is_dir($filePath) ? delete_form($file, $user) : unlink($filePath);
        }
    }
    rmdir(path . 'users/private/' . $user . '/' . $file_name);

    return;
}

function save_form($user, $title, $new_content)
{
    $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $title . '.json', "w");
    fwrite($file, $new_content);
    fclose($file);
}

function save_response($user, $title, $file_name, $content)
{
    $id = 0;
    $errcode = 1;
    while ($errcode != 0) {
        if ($id == 0) {
            $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $file_name . '.json', "x");
        } else {
            $file = fopen(path . 'users/private/' . $user . '/' . $title . '/' . $file_name . '(' . $id . ')' . '.json', "x");
        }
        $id++;
        if ($file == false) {
            $errcode = 301;
        } else {
            fwrite($file, $content);
            $errcode = 0;
        }
        fclose($file);
    }
    return $errcode;
}
