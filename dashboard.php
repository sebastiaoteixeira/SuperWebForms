<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <script src="jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebForms</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="dashboard.css">


    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'pt-PT',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script src="main.js"></script>

</head>

<body>
    <header></header>
    <table class="forms">
        <tr>
            <th>
                <h1>Meus Formulários</h1>
            </th>
            <td></td>
            <th>
                <button class="obtn main-btn right new">Criar novo</button>
            </th>
        </tr>
        <tr></tr>
            <?php
            $qtd_forms = 0;

            if ($qtd_forms == 0) {
                echo "<tr><th></th><th>Ainda não existem formulários na tua biblioteca. Prime 'Criar novo' para começar a criar o teu primeiro formulário.</th></tr><tr></tr><tr></tr><tr></tr>'";
            } else {
                for ($form_number = 0; $form_number < $qtd_forms; $form_number++) {
                    if ($form_number  == 0) {
                        echo '<tr><td>' . $content[$form_number] . '</td>';
                    } elseif ($form_number == ($qtd_forms - 1)) {
                        echo '<td>' . $content[$form_number] . '</td></tr>';
                    } elseif ($form_number % 3 == 0) {
                        echo '</tr><tr><td>' . $content[$form_number] . '</td>';
                    } else {
                        echo '<td>' . $content[$form_number] .'</td>';
                    }
                }
            }
            ?>

    </table>
    <footer></footer>

</body>

</html>