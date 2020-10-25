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
    if($key==2){
        echo '<div class="flex-element news-element"><div class="_fa7cdd4c68507744" data-zone="cd3c18d69f9649e39dea24d180068f16" style="width:336px;height:280px;display: inline-block;margin: 0 auto"></div></div>';
    }
}