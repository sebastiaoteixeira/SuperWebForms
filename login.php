<?php


include 'mysql.php';
include 'redirect.php';

function sendError($err_code)
{
    switch ($err_code) {
        case 101:
    }
}


function salt($email)
{
    $conn = new mysqli(constant("SQLServer"), constant("SQLUsername"), constant("SQLPassword"), constant("database"));


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $safe_email = $conn->real_escape_string($email);

    $obtainSalt = "SELECT time FROM Accounts WHERE email = ?;";

    $stmt = $conn->prepare($obtainSalt);
    $stmt->bind_param("s", $safe_email);
    $stmt->execute();
    $stmt->bind_result($date);
    $stmt->fetch();
    $stmt->close();

    return $date;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['e-mail'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];
    if ($remember == true) {
        $expiration = time() + (86400 * 7);
    } else {
        $expiration = 0;
    }

    $salt = salt($email);
    $password = hash("sha3-384", $password . $salt);
    $password = hash("sha512", $password);
    if (readFromDatabase($email, $password) == 0) {
        $id = create_session($email, $remember);

        setcookie('Login_Token', $id, $expiration, '/');
        dashboard();
    } else {
        echo 'Email/Password incorreto. Por favor reintroduza os dados.';
        echo "<script>setTimeout(function () {
            window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login.html"
            . "');
        }, 3000);</script>";
    }
}
