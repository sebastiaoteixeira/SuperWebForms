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
    <title>WebForms - Painel de Controlo</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="icon" href="img/logo/favicon.png">

	<!-- Matomo -->
	<script type="text/javascript">
	  var _paq = window._paq = window._paq || [];
	  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
	    var u="//superwebforms.infinityfreeapp.com/matomo/";
	    _paq.push(['setTrackerUrl', u+'matomo.php']);
	    _paq.push(['setSiteId', '1']);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
	    g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<!-- End Matomo Code -->

	<noscript>
		<!-- Matomo Image Tracker-->
		<img src="https://superwebforms.infinityfreeapp.com/matomo/matomo.php?idsite=1&amp;rec=1" style="border:0" alt="" />
		<!-- End Matomo -->
	</noscript>

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
    <script src="mobile_adjust.js"></script>
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
                <td>
                    <h3 style="text-align:right;">Copia e partilha:</h3>
                    <input style="width:180px;float:right;" type="text" name="share_id" id="share_id" onclick="this.focus();this.select()" readonly="readonly" value="<?php echo url . '/form.php?id=' . get_formID($user, $form->title); ?>">                </td>
            </tr>
            <tr height="50px"></tr>
            <?php
            $title = get_filesName($user . '/' . $form->title);
            foreach ($title as $key => $form_name) {
                if ($form_name == ($form->title . '.json')) {
                    unset($title[$key]);
                }
            }
            $qtd_forms = count($title);

            if ($qtd_forms == 0) {
                echo "<tr><th></th><td>Ainda não existem submissões neste formulários.</td></tr><tr></tr><tr></tr><tr></tr>";
            } else {
                $form_number = 0;
                foreach ($title as $form_name) {
                    if ($form_number  == 0) {
                        echo '<tr><td><div class="form-container"><a style="color:black;" href="filledForm.php?form_name='.$form->title.'&title=' . substr($form_name, 0, -5) . '">' . substr($form_name, 0, -5) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></div></td>';
                    } elseif ($form_number == ($qtd_forms - 1)) {
                        echo '<td><div class="form-container"><a style="color:black;" href="filledForm.php?form_name='.$form->title.'&title=' . substr($form_name, 0, -5) . '">' . substr($form_name, 0, -5) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></div></td></tr>';
                    } elseif ($form_number % 3 == 0) {
                        echo '</tr><tr><td><div class="form-container"><a style="color:black;" href="filledForm.php?form_name='.$form->title.'&title=' . substr($form_name, 0, -5) . '">' . substr($form_name, 0, -5) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></td>';
                    } else {
                        echo '<td><div class="form-container"><a style="color:black;" href="filledForm.php?form_name='.$form->title.'&title=' . substr($form_name, 0, -5) . '">' . substr($form_name, 0, -5) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete_form.php?name=' . $form_name . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a></td>';
                    }
                    $form_number++;
                }
            }
            ?>

            <tr style="height:100px;"></tr>
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