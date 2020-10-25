<?php
include 'mysql.php';
include 'redirect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    validateUser($_GET['token']);
    echo "<h1>Conta validada com sucesso!</h1>";
    index(3000);
}