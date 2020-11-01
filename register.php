<?php

include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';
include_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


function sendError($err_code)
{
    switch ($err_code) {
        case 101:
            echo 'Password deve conter pelo menos 8 caracteres.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login.html"
                . "');
            }, 5000);</script>";
                die();
            break;

        case 102:
            echo 'Confirmação deve ser igual à password.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
                die();
            break;

        case 103:
            echo 'Password deve conter pelo menos 4 letras.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
                die();
            break;

        case 104:
            echo 'Password deve conter pelo menos um número.';
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
                die();
            break;

        case 105:
            echo "Password deve conter pelo menos um dos seguintes caracteres especiais: !.,;:#$%&()?'«»¹@£§½¬{}@ł€¶ŧ←↓→øþæßðđŋħłµn”“¢»";
            echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, 5000);</script>";
                die();

            break;

        case 111:
            echo 'Email inválido.';
            echo "<script>setTimeout(function () {
                    window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
                }, 5000);</script>";
                    die();

            break;

        case 211:
            echo 'Email duplicado.';
            echo "<script>setTimeout(function () {
                        window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
                    }, 5000);</script>";
                        die();

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
    return time();
}


function setName($postName, $postAnonym)
{
    if ($postAnonym == 'true') {
        return 'anonymous';
    } else {
        return $postName;
    }
}

function sendValidityEmail($email, $name, $userKey)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->isHTML(true);
    $mail->Username = userMail;
    $mail->Password = passMail;
    $mail->From = userMail;
    $mail->FromName = 'superWebForms';
    $mail->Subject = "Valide a sua conta - superWebForms";
    $mail->Body = 'Olá <b>' . $name . '</b>,<br><br>Bem-vindo(a) a superWebForm.com!<br>Antes de poderes partilhar os teus formulários, é necessário confirmar o registro.<br>Para o fazer clique:<a href="superwebforms.infinityfreeapp.com/validateAccount.php?token=' . $userKey . '">Aqui</a><br><br>Se a sua conta não for confirmada em 4 dias ela será eliminada permanentemente.';
    $mail->addAddress($email);
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    } else {
        echo 'The email message was sent.';
        return true;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	if (isset($_POST['email']) && $_POST['email']) {
   	 $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	} else {
	    // set error message and redirect back to form...
	    header('location: register.html');
	    exit;
	}
 
	$token = $_POST['token'];
	$action = $_POST['action'];

	// call curl to POST request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	$arrResponse = json_decode($response, true);
 
	// verify the response
	if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
	
    $username = setName($_POST['username'], $_POST['anonymous']);

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    $emailValidity = verifyEmail($email);
    $passwordValidity = verifyPassword($password, $confirm);

    if ($emailValidity == 0) {
        if ($passwordValidity == 0) {
            $salt = salt();
            $password .= $salt;
            
            $password = hash("sha3-384", $password);
            $registerToken = sendToDatabase($email, $username, $password, $salt);


            $id = create_session($email, $remember);
            setcookie('Login_Token', $id, 0, '/');
            if (sendValidityEmail($email, $username, $registerToken)) {
                create_user_paths($email);
                dashboard();
            }
        } else {
            sendError($passwordValidity);
        }
    } else {
        sendError($emailValidity);
    }
    } else {
	    echo '<h1>Recaptcha detetou atividade maliciosa. Por favor, tente novamente</h1>';
        register(2000);
	}
}
?>
