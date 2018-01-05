<?php

class sendMail{


  public function __construct($contents,$subject){
    $this->contents = $contents;
    $this->subject  = $subject;
    $this->header   =  'MIME-Version: 1.0'  .  "\r\n" ;
    $this->header  .=  'Content-type: text/html; charset=utf-8'  .  "\r\n" ;
    $this->header  .= "From:zhanglongx";
  }



  private function tolist(){
    $list = [
      "334557725@qq.com",
      "zhanglongx1104@hotmail.com",
      "sunyuantao16@gmail.com"
    ];
    return $list;
  }


  public function send(){
     $mail_list = $this->tolist();
     foreach($mail_list as $to){
       mb_send_mail($to,$this->subject,$this->contents,$this->header);
     }

  }


}

 ?>
