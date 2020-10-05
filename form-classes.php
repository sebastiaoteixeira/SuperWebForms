<?php
include_once 'files-manager.php';

class form
{

  public $title;
  public $description;
  public $public;

  public $timed;
  public $hour;
  public $date;
  public $pages = array();

  public function __construct($title, $description, $timed, $hour, $date)
  {
    $this->title = $title;
    $this->description = $description;
    $this->timed = $timed;
    $this->hour = $hour;
    $this->date = $date;
    $firstPage = new page(null, null);
    array_push($this->pages, $firstPage);
  }



  public function print($keyPage, $keyBlock)
  {
    $block = $this->pages[$keyPage]->blocks[$keyBlock];
    return '<a href="deleteBlock.php?title=' . $this->title . '&keyP=' . $keyPage . '&keyB=' . $keyBlock . '"><img class="trash" style="height:20px;" src="img/icon/3592821-garbage-can-general-office-recycle-bin-rubbish-bin-trash-bin-trash-can_107760.svg"></img></a>' . $block->htmlBlock;
  }
}

class page
{
  public $timed;
  public $hour;
  public $blocks = array();

  public function __construct($timed, $hour)
  {
    $this->timed = $timed;
    $this->hour = $hour;
  }

  public function addTextQuestion($question, $correct, $rows)
  {
    $newBlock = new textQuestion($question, $correct, $rows);
    array_push($this->blocks, $newBlock);
  }
}

class block
{
  public $question;
  public $correct;
  public $htmlBlock;
  public $required;
  public $response;
}

class textQuestion extends block
{
  public $rows;
  public function __construct($question, $correct, $rows)
  {
    $this->question = $question;
    $this->correct = $correct;
    $this->rows = $rows;
    $this->required = false;
    $this->htmlBlock = '<div><div><h2>' . $this->question . '</h2></div><div><textarea name="' . $this->question . '" class="textQuestion" cols=32 rows=' . $this->rows . '></textarea></div><br>';
  }
}


function getOForm($user, $form_name, $title = null)
{
  if ($title == null) {
    $formDataTxt = read_form($form_name, $user);
    $formData = json_decode($formDataTxt);

    $form = new form($formData->title, $formData->description, $formData->timed, $formData->hour, $formData->date);
    foreach ($formData->pages as $key => $page) {
      foreach ($page->blocks as $block) {
        $form->pages[$key]->addTextQuestion($block->question, $block->correct, $block->rows);
      }
    }
  } else {
    $formDataTxt = read_response($form_name, $title, $user);
    $formData = json_decode($formDataTxt);

    $form = new form($formData->title, $formData->description, $formData->timed, $formData->hour, $formData->date);
    foreach ($formData->pages as $page) {
      foreach ($page->blocks as $block) {
        $form->page->addTextQuestion($block->question, $block->correct, $block->rows);
      }
    }
  }
  return $form;
}
