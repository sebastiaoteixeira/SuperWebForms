<?php
include 'mysql.php';

$news = get_news();
?>
<div class='flex-element news-element'>
    <h2><?php echo $news[0][1]?></h2>
    <p><?php echo $news[0][2]?></p>
<h3 class="right"><?php echo $news[0][3]?></h3>
</div>


<div class='flex-element news-element'>
<h2><?php echo $news[1][1]?></h2>
<p><?php echo $news[1][2]?></p>
<h3 class="right"><?php echo $news[1][3]?></h3>
</div>


<div class='flex-element news-element'>
<h2 class="center"><?php echo $news[2][1]?></h2>
<p><?php echo $news[2][2]?></p>
<h3 class="right"><?php echo $news[2][3]?></h3>
</div>



<div class='flex-element ad-banner'>banner</div>


