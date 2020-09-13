<?php
define('path', "/path/to/site");

function create_user_paths($email){
    mkdir(path . "/users/private" . $email, 0750);
    mkdir(path . "/users/public" . $email, 0750);
}