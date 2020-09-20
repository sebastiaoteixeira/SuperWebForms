<?php
include 'mysql.php';
include 'files-manager.php';
include 'form-classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Session_ID']);
    $form_name = $_GET['title'];

    $formDataTxt = read_form($form_name, $user);
    $formData = json_decode($formDataTxt);

    $form = new form($formData->title, $formData->description, $formData->timed, $formData->hour, $formData->date);
    foreach ($formData->blocks as $block) {
        $form->addTextQuestion($block->question, $block->correct, $block->incorrect);
    }
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
    <!--[if lt IE 9]> 
        <script> document.createElement("stack"); </script>
    <![endif]-->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script src="main.js"></script>

</head>

<body>
    <header <?php
            if ($form->title == null) {
                echo 'style="display:none;"';
            } else {
                echo 'style="position:static"';
            }
            ?>></header>

    <div id="head">
        <table>
            <tr>
                <th>
                    <h1 style="text-align:left;"><?php echo $form->title; ?></h1>
                </th>
                <td>
                    <h3 style="text-align:right;">Copia e partilha:</h3>
                    <input style="width:180px;float:right;" type="text" name="share_id" id="share_id" onclick="this.focus();this.select()" readonly="readonly" value="1123">
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
        <button id="formConfig-btn" class="flex-button">Configurações do Formulário</button>
        <button id="pageConfig-btn" class="flex-button">Configurações da página</button>
        <button id="newPage-btn" class="flex-button">Nova página</button>
    </div>
    <div id="spacer"></div>


    <div class="modal">
        <div id="new-block" class="modal-content animatezoom">
            <form id="newform" action="saveBlock.php" method="GET">
                <input style="width:180px;float:right;visibility:hidden;" type="text" name="form_title" id="form_title" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo $form->title; ?>"></td>

                <label for="question">Questão:</label><br>
                <input type="text" name="question" id="question"><br>
                <label for="type">Tipo:</label><br>
                <select id="type" name="type">
                    <option value="text">Resposta de Texto</option>
                </select><br><br>
                <button style="float: right;" class="sqr obtn" type="submit">Confirmar</button>
            </form>
        </div>



        <div id="form-config" class="modal-content animatezoom">
            <form id="newform" action="changeFormConf.php" method="get">
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


        <div id="page-config" class="modal-content animatezoom">
            <form id="newform" action="changePageConf.php" method="get">
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


    </div>
    <footer></footer>

    <script type="text/javascript" src="form.js"></script>

    <script>

    </script>

    <script>
        $(document).ready(function() {
            let spaceSize = $(document).height() - $('#form').height() - 1000;
            $('#spacer').height(spaceSize);

            <?php
            foreach ($form->blocks as $key => $block) {
                $html = $form->print($key);
                echo "$('section').append('" . $html . "');";
            }
            ?>


            $('.new').click(function() {
                $('.modal').css('display', 'block');
                let hide = ['#form-config', '#page-config', '#new-page'];
                for (let id of hide) {
                    $(id).css('display', 'none');
                }
            });

            $('.new').click(function() {
                $('.modal').css('display', 'block');
                let hide = ['#form-config', '#page-config', '#new-page'];
                for (let id of hide) {
                    $(id).css('display', 'none');
                }
            });

            $('.new').click(function() {
                $('.modal').css('display', 'block');
                let hide = ['#form-config', '#page-config', '#new-page'];
                for (let id of hide) {
                    $(id).css('display', 'none');
                }
            });

            $('.new').click(function() {
                $('.modal').css('display', 'block');
                let hide = ['#form-config', '#page-config', '#new-page'];
                for (let id of hide) {
                    $(id).css('display', 'none');
                }
            });



            $('.modal').click(function(target) {
                if (!$(event.target).closest("#new-block").length) {
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
</body>

</html>