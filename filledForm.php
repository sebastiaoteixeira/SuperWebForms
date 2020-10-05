<?php
include 'mysql.php';
include 'files-manager.php';
include 'redirect.php';
include 'form-classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = get_email($_COOKIE['Login_Token']);
    $form_name = $_GET['form_name'];
    $title = $_GET['title'];
    $form = getOForm($user, $form_name, $title);
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


    <footer></footer>

    <script type="text/javascript" src="form.js"></script>


    <script>
        $(document).ready(function() {
            let spaceSize = $(document).height() - $('#form').height() - 700;
            let spaceSizeTxt = String(spaceSize) + 'px';
            $('footer').css('margin-top', spaceSize);

            <?php
            foreach ($form->page[0]->blocks as $key => $block) {
                $html = $form->print($key);
                echo "$('section').append('" . $html . "');";
                echo "$('textarea').last().prop('value','" . $block->response . "');";
            }
            echo "$('textarea').prop('readonly', 'readonly');";
            echo "$('.trash').remove();";
            ?>

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
      <div id="cookie"></div>

</body>

</html>