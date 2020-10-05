<?php
include 'mysql.php';

$news = get_news();
echo '<div class="flex-element news-element"><h2>'.$news[2][1].'</h2><p>'.$news[2][2].'</p><h3 style="float:right">'.$news[2][3].'</h3></div>';
echo '<div class="flex-element news-element"><h2>'.$news[1][1].'</h2><p>'.$news[1][2].'</p><h3 style="float:right">'.$news[1][3].'</h3></div>';
echo '<div class="flex-element news-element"><h2>'.$news[0][1].'</h2><p>'.$news[0][2].'</p><h3 style="float:right">'.$news[0][3].'</h3></div>';
