<?php
//  MySQL/MariaDB Database
define("SQLServer", "MySQLServerAddress");
define("SQLUsername", "MySQLUsername");
define("SQLPassword", "MySQLPassword");
define("database", "MySQLDatabase");

//Segurança contra SQLInjection (Prepared Query)
function prepareQuery($conn, $query, $type, array $parameters)
{
    $stmt = $conn->prepare($query);
    if($stmt != false){
    call_user_func_array(array($stmt, "bind_param"), refValues(array_merge(array($type), $parameters)));
    $stmt->execute();
    $res = $stmt->fetch();
    $stmt->close();} else {
        echo'SQL Error';
    }

    return $res;
}

function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

function readFromDatabase($email, $password)
{
    
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $safe_email = $conn->real_escape_string($email);

    $readPassword = "SELECT * FROM Accounts WHERE email = ? AND password = ?;";

    $res = prepareQuery($conn, $readPassword, "ss", array($safe_email, $password));

    if ($res != NULL) {
        $out = 0;
        echo 'success';
    } else {
        $out = 131;
    }

    $conn->close();
    return $out;
}


function sendToDatabase($email, $name, $password, $time)
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_email = $conn->real_escape_string($email);
    $safe_name = $conn->real_escape_string($name);

    
    $duplicateSQLVerification = "SELECT * FROM Accounts WHERE email = ?;";

    $res = prepareQuery($conn, $duplicateSQLVerification, "s", array($safe_email));


    if ($res == NULL) {
        $addToDatabase = "INSERT INTO Accounts (email, name, password, time, registerToken, verified) VALUES (?, ?, SHA2(?,512), ?, SHA1(" . time() . "), false);";

        $res = prepareQuery($conn, $addToDatabase, "ssss", array($safe_email, $safe_name, $password, $time));

        $out = 0;
    }


    //SQL Query - obtenção do id
    $readID = "SELECT RegisterToken FROM Accounts ORDER BY ID DESC LIMIT 1;";

    $res = $conn->query($readID);
    $id = $res->fetch_row();


    $conn->close();
    return $id[0];
}

function get_name($email)
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $safe_email = $conn->real_escape_string($email);


    $readName = "SELECT name FROM Accounts WHERE email='" . $safe_email . "';";

    $res = $conn->query($readName);
    $name = $res->fetch_all();

    $out = $name[0][0];

    $conn->close();
    return $out;
}

function get_email($id)
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Segurança contra SQLInjection
    $safe_id = $conn->real_escape_string($id);


    //SQL Query - obtenção do id
    $readID = "SELECT Email FROM Login WHERE Hash='" . $safe_id . "';";


    $res = $conn->query($readID);

    $email = $res->fetch_all();

    return $email[0][0];
}

function get_news()
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $getNews = "SELECT * FROM News ORDER BY id DESC LIMIT 5;";

    $res = $conn->query($getNews);

    $out = $res->fetch_all();


    $conn->close();
    return $out;
}

function get_formID($user, $form_name){
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Segurança contra SQLInjection
    $safe_user = $conn->real_escape_string($user);
    $safe_title = $conn->real_escape_string($form_name);

    //SQL Query - obtenção do id
    $readID = "SELECT * FROM Forms WHERE User='" . $safe_user . "' AND Form='". $safe_title ."';";


    $res = $conn->query($readID);

    $id = $res->fetch_all();

    return $id[0][0];
}

function get_formFromID($id){
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Segurança contra SQLInjection
    $safe_ID = $conn->real_escape_string($id);

    //SQL Query - obtenção do id
    $readID = "SELECT * FROM Forms WHERE ID='" . $safe_ID . "';";


    $res = $conn->query($readID);

    $id = $res->fetch_row();

    return $id;
}

function new_formID($user, $form_name){
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Segurança contra SQLInjection
    $safe_user = $conn->real_escape_string($user);
    $safe_title = $conn->real_escape_string($form_name);


    //SQL Query - obtenção do id
    $newForm = "INSERT INTO Forms (user, form) VALUES (?,?);";

    prepareQuery($conn, $newForm, "ss", array($safe_user, $safe_title));

    return;
}

function removeAccountFromDatabase($user){
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_user = $conn->real_escape_string($user);

    $removeForm = "DELETE FROM Accounts WHERE email=?;";
    prepareQuery($conn, $removeForm, "s", array($safe_user));

    $removeForm = "DELETE FROM Forms WHERE user=?;";
    prepareQuery($conn, $removeForm, "s", array($safe_user));

    $removeForm = "DELETE FROM Login WHERE email=?;";
    prepareQuery($conn, $removeForm, "s", array($safe_user));

    $conn->close();
    return;
}

function removeFormID($title, $user)
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_title = $conn->real_escape_string($title);
    $safe_user = $conn->real_escape_string($user);

    $removeForm = "DELETE FROM Forms WHERE user=? AND form=?;";

    prepareQuery($conn, $removeForm, "ss", array($safe_user, $safe_title));

    $conn->close();
    return;
}

function removeOldSessions()
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $removeSessions = "DELETE FROM Login WHERE Expire < NOW();";

    $conn->query($removeSessions);


    $conn->close();
    return;
}


function create_session($email, $remember)
{
    //Inicia-se conecção com as seguintes constantes

    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_email = $conn->real_escape_string($email);

    if ($remember == true) {
        $time = "168:00:00";
    } else {
        $time = "24:00:00";
    }

    $create_session = "INSERT INTO Login (Email, Hash, Expire) VALUES (?, SHA1(" . time() . "), (ADDTIME(NOW(), ?)));";

    prepareQuery($conn, $create_session, "ss", array($safe_email, $time));

    $readID = "SELECT Hash FROM Login ORDER BY ID DESC LIMIT 1;";

    $res = $conn->query($readID);
    $id = $res->fetch_all();


    $conn->close();

    removeOldSessions();

    return $id[0][0];
}

function validateUser($registerToken){
        //Inicia-se conecção com as seguintes constantes

    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);

    //Verifica-se a presença de erros
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_registerToken = $conn->real_escape_string($registerToken);

    $create_session = "UPDATE Accounts
SET verified=1
WHERE RegisterToken=?;";

    prepareQuery($conn, $create_session, "s", array($safe_registerToken));

    $conn->close();

    return;
}
