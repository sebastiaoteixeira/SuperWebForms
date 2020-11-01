<?php
include 'mysql.php';

$news = get_news();
echo '<style>
h2 {
    text-align: left!important;
}
</style>';
foreach($news as $key => $news_unity){
    echo '<div class="flex-element news-element"><h2>'.$news_unity[1].'</h2><p>'.$news_unity[2].'</p><div id="date-spacer"></div><h3 style="float:right;">'.$news_unity[3].'</h3></div>';
}