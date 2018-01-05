<?php

ini_set('memory_limit',-1);
mb_internal_encoding("utf-8");

require_once dirname(__FILE__).'/../SerieA/SerieANews.php';
require_once dirname(__FILE__).'/../mail/sendmail.php';

$serieA = new SerieA();
$serieA_result = $serieA->accept(NULL);

$sendMail = new sendMail($serieA_result,"SerieA Result");
$sendMail->send();
