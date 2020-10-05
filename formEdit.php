<?php
include 'mysql.php';
include 'files-manager.php';
include 'form-classes.php';
include 'redirect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $user = get_email($_COOKIE['Login_Token']);
    $form_name = $_GET['title'];
    $form = getOForm($user, $form_name);
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <script src="jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebForms - <?php echo $form->title; ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="formBlocks.css">


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
    <header <?php
            if ($form->title == null) {
                echo 'style="display:none;"';
            } else {
                echo 'style="position:static;opacity:1;"';
            }
            ?>></header>
    <div></div>

    <div id="head">
        <table>
            <tr>
                <th>
                    <h1 style="text-align:left;"><?php echo $form->title; ?></h1>
                </th>
                <td>
                    <h3 style="text-align:right;">Copia e partilha:</h3>
                    <input style="width:180px;float:right;" type="text" name="share_id" id="share_id" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo url . '/form.php?id=' . get_formID($user, $form->title); ?>">
                </td>
                <th>
                    <button style="position:fixed;" class="obtn main-btn right new">+</button>
                </th>
            </tr>
        </table>
    </div>

    <div style="text-align:center">
        <section id="form">
            <h3><?php echo $form->description; ?></h3>


        </section>
    </div>
    <div class="flex-container">
        <a href="submissions.php?title=<?php echo $form->title; ?>"><button id="submitted" class="obtn flex-button">Entregues</button></a>
        <button id="formConfig-btn" class="flex-button">Configurações do Formulário</button>
        <!--
        <button id="pageConfig-btn" class="flex-button">Configurações da página</button>
        <button id="newPage-btn" class="flex-button">Nova página</button>
        -->
    </div>

    <div id="modal1" class="modal">
        <div id="new-block" class="modal-content animatezoom">
            <form action="saveBlock.php" method="get">
                <input style="width:10px;float:right;visibility:hidden;" type="text" name="form_title" id="form_title" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo $form->title; ?>"></td>
                <input style="width:10px;float:right;visibility:hidden;" type="text" name="page" id="page" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo 0; ?>"></td>

                <label for="question">Questão:</label><br>
                <input type="text" name="question" id="question"><br>
                <label for="type">Tipo:</label><br>
                <select id="type" name="type">
                    <option value="text">Resposta de Texto</option>
                </select><br>
                <div class="shortQ">
                    <label for="rows">Linhas:</label><br>
                    <input type="number" name="rows" id="rows"></div>
                <br><br>
                <button class="rect obtn main-btn right" type="submit">Confirmar</button>
            </form>
        </div>
    </div>


    <div id="modal2" class="modal">
        <div id="form-config" class="modal-content animatezoom">
            <form id="newform" action="changeFormConf.php" method="get">
                <input style="width:10px;float:right;visibility:hidden;" type="text" name="oldTitle" id="oldTitle" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo $form->title; ?>"></td>

                <label for="title">Título:</label><br>
                <input type="text" name="title" id="title" value="<?php echo $form->title; ?>"><br>
                <label for="description"> Descrição:</label><br>
                <textarea id="description" name="description" cols=16 rows=3><?php echo $form->description ?></textarea><br><br>
                <label for="timed">Temporizador:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="timed" name="timed" id="timed" <?php if ($form->timed) {
                                                                                echo 'checked';
                                                                            } ?>><br>
                <input type="radio" id="temp_type1" name="temp_type" class="temp" value="upUntil" <?php if ($form->hour != null && $form->date != null) {
                                                                                                        echo ' checked';
                                                                                                    } ?>>
                <label for="temp_type1" class="temp">Até às</label><br>
                <input type="radio" id="temp_type2" name="temp_type" class="temp" value="current" <?php if ($form->hour != null && $form->date == null) {
                                                                                                        echo ' checked';
                                                                                                    } ?>>
                <label for="temp_type2" class="temp">Durante</label><br>
                <label for="hour">Hora:</label><br>
                <input type="time" name="hour" id="hour" class="temp time" value="<?php echo $form->hour; ?>"><br>
                <label for="date">Data:</label><br>
                <input type="date" name="date" id="date" class="temp time" value="<?php echo $form->date; ?>"><br>
                <button id="createF" type="submit" class="rect obtn main-btn right">Salvar</button>
            </form>
        </div>
    </div>

    <!--
    <div id="modal3" class="modal">
        <div id="page-config" class="modal-content animatezoom">
            <form id="newform" action="changePageConf.php" method="get">
                <label for="question" value="">Questão:</label><br>
                <input type="text" name="question" id="question"><br>
                <label for="timed">Temporizador:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="timed" name="timed" id="timed"><br>
                <input type="radio" id="temp_type1" name="temp_type" class="temp" value="upUntil" checked="checked">
                <label for="temp_type1" class="temp">Até às</label><br>
                <input type="radio" id="temp_type2" name="temp_type" class="temp" value="current">
                <label for="temp_type2" class="temp">Durante</label><br>
                <label for="hour">Hora:</label><br>
                <input type="time" name="hour" id="hour" class="temp time"><br><br><br>
                <label for="date">Data:</label><br>
                <input type="date" name="date" id="date" class="temp time"><br>
                <button id="createF" type="submit" class="rect obtn main-btn right">Criar</button>
            </form>
        </div>
    </div>

    <div id="modal4" class="modal">
        <div id="new-page" class="modal-content animatezoom">
            <form id="newform" action="addPage.php" method="get">
                <label for="question">Questão:</label><br>
                <input type="text" name="question" id="question"><br>
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
        -->

    <footer></footer>

    <script type="text/javascript" src="form.js"></script>


    <script>
        $(document).ready(function() {
            let spaceSize = $(document).height() - $('#form').height() - 700;
            let spaceSizeTxt = String(spaceSize) + 'px';
            $('footer').css('margin-top', spaceSize);

            <?php
            foreach ($form->pages[0]->blocks as $key => $block) {
                $html = $form->print(0, $key);
                echo "$('section').append('" . $html . "');";
            }
            ?>


            $('.new').click(function() {
                $('#modal1').css('display', 'block');
            });

            $('#formConfig-btn').click(function() {
                $('#modal2').css('display', 'block');
            });

            /*$('#pageConfig-btn').click(function() {
                $('#modal3').css('display', 'block');
            });

            $('#newPage-btn').click(function() {
                $('#modal4').css('display', 'block');
            });*/



            $('.modal').click(function(target) {
                if (!$(event.target).closest(".modal-content").length) {
                    $('.modal').css('display', 'none');
                }
            });

            if ($('#timed').prop("checked")) {
                $('.temp').prop('disabled', false);
            }
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
</body>
<div id="cookie"></div>

</html>