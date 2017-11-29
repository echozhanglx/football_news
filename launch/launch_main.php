<?php

require_once '../SerieA/SerieANews.php';
require_once '../mail/sendmail.php';

$serieA = new SerieA();
$serieA_result = $serieA->accept();

$sendMail = new sendMail($serieA_result,"SerieA Result");
$sendMail->send();
