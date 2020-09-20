<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webforms - Explorar</title>
</head>

<body style="text-align:center">
    <h1>Brevemente disponível</h1>
    <script type="text/javascript">
    <?php
        echo "setTimeout(function() {
                    window.location.replace('" . (isset($_SERVER['
                        HTTPS ']) && $_SERVER['
                        HTTPS '] === '
                        on ' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/"
                        .
                        "');
                    }, 5000);";
                
                ?>
    </script>
</body>

</html>