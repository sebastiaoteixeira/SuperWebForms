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
    <script src="main.js"></script>

</head>

<body>
    <header></header>

    <div id="head">
        <table>
            <tr>
                <th>
                    <h1 style="text-align:left;"><?php echo $form->title; ?></h1>
                </th>
            </tr>
        </table>
    </div>

    <div style="text-align:center">
        <section id="form">
            <form id="formBlocks" method="post" action="submitForm.php">
                <div id="form-content">
                    <h3><?php echo $form->description; ?></h3>
                </div>
            </form>
        </section>
    </div>

    <footer></footer>

    <script type="text/javascript" src="form.js"></script>

    <script>
        $(document).ready(function() {
            let spaceSize = $(document).height() - $('#form').height() - 700;
            $('footer').css('margin-top', spaceSize);


            <?php
            foreach ($form->pages[0]->blocks as $key => $block) {
                $html = $form->print(0, $key);
                echo "$('#form-content').append('" . $html . "');";
                echo "$('.formQuestion').last().prop('value', '" . $block->response . "');";
            }
            ?>
            $('.trash').remove();


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