<?php
//  MySQL/MariaDB Database
define("SQLServer", "");
define("SQLUsername", "");
define("SQLPassword", "");
define("database", "");

//Segurança contra SQLInjection (Prepared Query)
function prepareQuery($conn, $query, $type, array $parameters)
{
    $stmt = $conn->prepare($query);
    call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $parameters));
    $stmt->execute();
    $res = $stmt->fetch();
    $stmt->close();

    return $res;
}

function readFromDatabase($email, $password, $time)
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
        $addToDatabase = "INSERT INTO Accounts (email, name, password, time) VALUES (?, ?, SHA2(?,512), ?);";

        $res = prepareQuery($conn, $addToDatabase, "ssss", array($safe_email, $safe_name, $password, $time));

        $out = 0;
    }

    $conn->close();
    return $out;
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
    $readID = "SELECT Email FROM Login WHERE ID=" . $safe_id . ";";

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

    $getNews = "SELECT * FROM News ORDER BY id DESC LIMIT 3;
    ";

    $res = $conn->query($getNews);



    if ($res != NULL) {
        $out = $res->fetch_all();
    }

    $conn->close();
    return $out;
}


function removeOldSessions()
{
    $conn = new mysqli(SQLServer, SQLUsername, SQLPassword, database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $removeSessions = "DELETE FROM Login WHERE Expire < NOW();";

    prepareQuery($conn, $removeSessions, "", array());


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

    echo '<br>connection<br>';

    //Segurança contra SQLInjection
    $safe_email = $conn->real_escape_string($email);

    //Atribuição de valor à variável $time
    if ($remember == true) {
        $time = "168:00:00";
    } else {
        $time = "12:00:00";
    }
    echo $time;

    //SQL Query - inserção de dados (temporários)
    $create_session = "INSERT INTO Login (Email, Expire) VALUES (?, (ADDTIME(NOW(), ?)));";

    //Execução
    echo prepareQuery($conn, $create_session, "ss", array($safe_email, $time));

    echo '<br>inserted<br>';

    //SQL Query - obtenção do id
    $readID = "SELECT id FROM Login ORDER BY ID DESC LIMIT 1;";
    echo '1';
    //
    $res = $conn->query($readID);
    $id = $res->fetch_all();
    echo var_dump($id);


    $conn->close();

    echo '<br>conn closed';

    //removeOldSessions();

    return $id[0][0];
}
