<?php
include 'redirect.php';
include 'files-manager.php';
include 'mysql.php';
include 'form-classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = get_formFromID($_POST['id']);
    $user = $data[1];
    $form_name = $data[2];

    $form = getOForm($user, $form_name);

    $pattern = '/_/i';

    $a = 0;
    foreach ($_POST as $key => $input) {

        if (!($key == 'id')) {
            foreach ($form->pages[0]->blocks as $block) {
                if ($block->question == preg_replace($pattern, ' ', $key)) {
                    if ($a == 0) {
                        $a = 1;
                        $firstQ = $input;
                    }
                    $block->response = $input;
                }
            }
        }
    }
    $formTxt = json_encode($form);
    save_response($user, $form_name, $firstQ, $formTxt);

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
    <header style="display: inline-block"></header>

    <h1 style="text-align:left;"><?php echo $form->title; ?></h1>


    <div style="text-align:center">
        <section>
            <h1 style="font-size:28pt;text-align:center;color:#050;">Submetido com sucesso</h1>
        </section>
    </div>

    <footer></footer>

    <script>
        $(document).ready(function() {
            let spaceSize = $(document).height() - $('section').height() - 500;
            let spaceSizeTxt = String(spaceSize) + 'px';
            $('footer').css('margin-top', spaceSize);
        });
    </script>
</body>

</html>
