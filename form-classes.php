<?php
class form
{

  public $title;
  public $description;
  //  public $public;
  //  public $formId;

  public $timed;
  public $hour;
  public $date;
  public $blocks = array();

  public function __construct($title, $description, $timed, $hour, $date)
  {
    $this->title = $title;
    $this->description = $description;
    $this->timed = $timed;
    $this->hour = $hour;
    $this->date = $date;
  }

  public function addTextQuestion($question, $correct, $incorrect)
  {
    $newBlock = new textQuestion($question, $correct, $incorrect);
    array_push($this->blocks, $newBlock);
  }

  public function print($key)
  {
      $block = $this->blocks[$key];
      return '<a href="deleteBlock.php?title=' . $this->title . '&key=' . $key . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a>' . $block->htmlBlock;

  }
}

class block
{
  public $question;
  public $correct;
  public $incorrect;
  public $htmlBlock;
}

class textQuestion extends block
{
  public function __construct($question, $correct, $incorrect)
  {
    $this->question = $question;
    $this->correct = $correct;
    $this->incorrect = $incorrect;
    $this->htmlBlock = '<div><h2>' . $this->question . '</h2></div><br>';
  }
}
