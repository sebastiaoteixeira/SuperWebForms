<?php


include 'mysql.php';
include 'login_cookie.php';
include 'redirect.php';

function sendError($err_code)
{
    switch ($err_code) {
        case 101:
            echo 'Password deve conter pelo menos 8 caracteres.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login.html"
                . "');
            }, 5000);</script>";
            break;

        case 102:
            echo 'Confirmação deve ser igual à password.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
            break;

        case 103:
            echo 'Password deve conter pelo menos 4 letras.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
            break;

        case 104:
            echo 'Password deve conter pelo menos um número.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
            break;

        case 105:
            echo "Password deve conter pelo menos um dos seguintes caracteres especiais: !.,;:#$%&()?'«»¹@£§½¬{}@ł€¶ŧ←↓→øþæßðđŋħłµn”“¢»";
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
            break;

        case 111:
            echo 'Email inválido.';
            echo "<script>setTimeout(function () {
                    window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
                }, 5000);</script>";
            break;

        case 211:
            echo 'Email duplicado.';
            echo "<script>setTimeout(function () {
                        window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
                    }, 5000);</script>";
            break;
    }
}

function verifyEmail($email)
{
    $pattern = "/@+/";
    if (preg_match($pattern, $email)) {
        if (get_name($email) == null) {
            return 0;
        } else {
            return 211;
        }
    } else {
        return 111;
    }
}

function verifyPassword($password, $confirm)
{
    class characterRules
    {
        private $letters = "/([\pL]){4,}/iu";
        private $numbers = "/([0-9])+/";
        private $special = "/[!.,;:#$%&()?'«»¹@£§½¬{}@ł€¶ŧ←↓→øþæßðđŋħłµn”“¢»]+/u";

        public function verifyLetters($string)
        {
            return preg_match($this->letters, $string);
        }
        public function verifyNumbers($string)
        {
            return preg_match($this->numbers, $string);
        }
        public function verifySpecial($string)
        {
            return preg_match($this->special, $string);
        }
    }

    $rules = new characterRules;

    if (strlen($password) < 8) {
        return 101;
    } elseif (!($confirm == $password)) {
        return 102;
    } elseif (!($rules->verifyLetters($password))) {
        return 103;
    } elseif (!($rules->verifyNumbers($password))) {
        return 104;
    } elseif (!($rules->verifySpecial($password))) {
        return 105;
    } else {
        return 0;
    }
}

function salt()
{
    $date = date("YmdHis");
    return $date;
}


function setName($postName, $postAnonym)
{
    if ($postAnonym == true) {
        return 'anonymous';
    } else {
        return $_POST['username'];
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = setName($_POST['username'], $_POST['anonymous']);

    $email = $_POST['e-mail'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    $emailValidity = verifyEmail($email);
    $passwordValidity = verifyPassword($password, $confirm);

    if ($emailValidity == 0) {
        if ($passwordValidity == 0) {
            $salt = salt();
            $password .= $salt;

            $password = hash("sha3-384", $password);
            if (sendToDatabase($email, $username, $password, $salt) == 0) {
                $id = create_session($email, $remember);
                setcookie('login', $id, 0, '/');
                create_user_paths($email);
                dashboard();
            }
        } else {
            sendError($passwordValidity);
        }
    } else {
        sendError($emailValidity);
    }
}
