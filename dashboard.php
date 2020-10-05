<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <script src="jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebForms - Painel de Controlo</title>
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
    <div id="forms">
        <table>
            <tr>
                <th>
                    <h1>Meus Formulários</h1>
                </th>
                <td></td>
                <th>
                    <button class="obtn main-btn right new">Criar novo</button>
                </th>
            </tr>
            <tr height="50px"></tr>
            <?php
            include 'mysql.php';
            include 'files-manager.php';


            $email = get_email($_COOKIE['Login_Token']);
            $title = get_filesName($email);
            $qtd_forms = count($title);

            if ($qtd_forms == 0) {
                echo "<tr><th></th><td>Ainda não existem formulários na tua biblioteca. Prime '<strong>Criar novo</strong>' para começar a criar o teu primeiro formulário.</td></tr><tr></tr><tr></tr><tr></tr>";
            } else {
                $form_number = 0;
                foreach ($title as $form_name) {
                    if ($form_number  == 0) {
                        echo '<tr><td><div class="form-container"><a style="color:black;" href="formEdit.php?title=' . $form_name . '">' . $form_name . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></div></td>';
                    } elseif ($form_number == ($qtd_forms - 1)) {
                        echo '<td><div class="form-container"><a style="color:black;" href="formEdit.php?title=' . $form_name . '">' . $form_name . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></div></td></tr>';
                    } elseif ($form_number % 3 == 0) {
                        echo '</tr><tr><td><div class="form-container"><a style="color:black;" href="formEdit.php?title=' . $form_name . '">' . $form_name . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></td>';
                    } else {
                        echo '<td><div class="form-container"><a style="color:black;" href="formEdit.php?title=' . $form_name . '">' . $form_name . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></td>';
                    }
                    $form_number++;
                }
            }
            ?>

            <tr style="height:100px;"></tr>

            <tr>
                <td></td>
                <td></td>
                <th><button id="delete_account" class="main-btn red right">Apagar conta</button></th>
            </tr>


            <div class="modal">
                <div class="modal-content animatezoom">
                    <form id="newform" action="new_form.php" method="post">
                        <label for="title">Título:</label><br>
                        <input type="text" name="title" id="title"><br>
                        <label for="description"> Descrição:</label><br>
                        <textarea id="description" name="description" cols=16 rows=3></textarea><br><br>
                        <label for="timed">Temporizador:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="timed" name="timed" id="timed"><br>
                        <input type="radio" id="temp_type1" name="temp_type" class="temp" value="upUntil" checked="checked">
                        <label for="temp_type1" class="temp">Até às</label><br>
                        <input type="radio" id="temp_type2" name="temp_type" class="temp" value="current">
                        <label for="temp_type2" class="temp">Durante</label><br>
                        <label for="hour">Hora:</label><br>
                        <input type="time" name="hour" id="hour" class="temp time"><br>
                        <label for="date">Data:</label><br>
                        <input type="date" name="date" id="date" class="temp time"><br>
                        <button id="createF" type="submit" class="rect obtn main-btn right">Criar</button>
                    </form>
                </div>
            </div>
        </table>
    </div>
    <footer></footer>

    <script type="text/javascript" src="form.js"></script>

    <script>

    </script>

    <script>
        $(document).ready(function() {





            $('#delete_account').click(function() {
                $('table').html('<div style="text-align:center; font-size:32pt;">Atenção! Se continuar a sua conta e todos os seus dados serão permanentemente eliminados.<br><a style="text-decoration: none;" href="delete.php"><buttons class="rect obtn main-btn red" style="font-color: black">Apagar dados e conta</button></a></div>');
            });

            $('.new').click(function() {
                $('.modal').css('display', 'block');
            });

            $('.modal').click(function(target) {
                if (!$(event.target).closest(".modal-content").length) {
                    $('.modal').css('display', 'none');
                }
            });

            $('.temp').prop('disabled', true);
            $('#timed').on('change', function() {
                $('.temp').prop('disabled', !($(this).prop("checked")));
            });

            $('#date').prop('disabled', true);
            $('.temp').on('change', function() {
                $('#date').prop('disabled', function() {
                    if ($('#temp_type2').is(':checked')) {
                        return true;
                    } else {
                        return false;
                    }
                });
            });

            $('#date').prop('min', new Date().toJSON.split('T')[0]);
        });
    </script>
      <div id="cookie"></div>

</body>

</html>