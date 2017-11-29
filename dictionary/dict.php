<?php

class Dict{

  public function __construct(){
    $this->lines = file("../setting/word/word_cn");
  }


  public function getDict($word){
    foreach ($this->lines as $line){
      $trans = explode(":",$line);
      if($word == $trans[0])
      return preg_replace("/\r\n|\r|\n/","",$trans[1]);
    }
    return $word;
  }


}


?>
