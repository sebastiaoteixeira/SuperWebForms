<script src="mobile_adjust.js"></script>
<link rel="stylesheet" href="header.css">
<div id="header">
    <a href="index.php"><img id='logo' class="" src="img/logo/mainicon.png" alt="logo" class="left">
    </a>
    <div class="top-buttons">
        <a href="explore.php"><button class="wbtn lbtn main-btn" id="explore">Explorar</button></a>
        <hr class="menu-spacer">
        <button class="wbtn lbtn main-btn" id="contact-btn" onclick="contact()">Contactar</button>
        <hr class="menu-spacer">

        <?php
        include 'mysql.php';

        if ($_COOKIE['Login_Token'] != null) {
            $email = get_email($_COOKIE['Login_Token']);
            $name = get_name($email);
            if ($email == null) {
                echo "<script>
            document.cookie = 'Login_Token=; expires=Thu, 18 Dec 2013 12:00:00 UTC';
            setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"
                    . "');
            }, 5000);</script>";
            } else {
                echo '<script type="text/javascript" src="loginbtn.js"></script>';
                echo '<button id="namebtn" class="rbtn right login-btn main-btn">' . $name . '</button>';
                echo '<div class="hide-menu">
            <button id="logout" class="rbtn right login-btn main-btn">Sair</button>
            <a href="dashboard.php"><button class="rbtn right login-btn main-btn">Painel de Controlo</button></a>

        </div>';
            }
        } else {
            echo '<a href="login.html">';
            echo '<button class="rbtn right login-btn main-btn">Entrar</button>';
            echo '</a>';
            echo '<hr class="menu-spacer">';
            echo '<a href="register.html">';
            echo '<button class="right obtn main-btn" id="register">Registro</button>';
            echo '</a>';
        }
        ?>

    </div>
    <img id="burger_menu" class="right" src="/img/menu/Hamburger_icon.svg_blank.png">
    <script>
        $(document).ready(function() {
            let windowWidth = $(window).width();
            if(windowWidth > 600){
                function adjTopBtn() {
                    let windowWidth = window.innerWidth;
                    let topButtons_width = String(windowWidth - 250) + 'px';
                
                    $('.top-buttons').css('width', topButtons_width);
                }
                adjTopBtn();
                setInterval(adjTopBtn, 2000);
            }
        })
    
    </script>
</div>
<div id="contact-space"></div>