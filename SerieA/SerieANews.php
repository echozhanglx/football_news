<?php

class SerieA{

  public function accept(){
    require_once dirname(__FILE__).'/../dictionary/dict.php';
    $this->dict = new Dict();
    $this->context = stream_context_create(array(
      'http' => array (
        'method' => 'GET',
        'header' => 'X-Auth-Token: b3688b3cc0164b7e94425386dbe7c510'
      )
    ));

    $this->getStanding();
    $next = $this->checkMatchDay();
    if($next){
      $this->getResult();
    }else{
      $this->result = $this->dict->getDict("no new match");
    }
    return $this->Contents();

  }


  private function getStanding(){
    $uri = 'http://api.football-data.org/v1/competitions/456/leagueTable';
    $response = file_get_contents($uri,false,$this->context);
    $fixtures = json_decode($response);
    $this->matchday = $fixtures->matchday;
    $this->table ="<tr><th>".$this->dict->getDict('position')."</th><th>".$this->dict->getDict('team')."</th><th>".$this->dict->getDict('playedGames')."</th><th>".$this->dict->getDict('points')."</th></tr>";
    foreach($fixtures->standing as $value){
      $this->table .= "<tr>";
      $this->table .= "<td>".$value->position."</td>";
      $this->table .= "<td>".$this->dict->getDict($value->teamName)."</td>";
      $this->table .= "<td>".$value->playedGames."</td>";
      $this->table .= "<td>".$value->points."</td>";
      $this->table .= "</tr>";
    }
  }

  private function getResult(){
    $uri = 'http://api.football-data.org/v1/competitions/456/fixtures/?matchday='.$this->matchday;
    $response = file_get_contents($uri,false,$this->context);
    $fixtures = json_decode($response);
    $this->result = "<tr><th>".$this->dict->getDict('Match Date')."</th><th>".$this->dict->getDict('Team')."</th><th>".$this->dict->getDict('Result')."</th></tr>";
    foreach ($fixtures->fixtures as $value){
      $this->result .= "<tr>";
      $this->result .= "<td>".date("Y-m-d",strtotime($value->date))."</td>";
      $this->result .= "<td>".$this->dict->getDict($value->homeTeamName)." : ".$this->dict->getDict($value->awayTeamName)."</td>";
      $this->result .= "<td>".$value->result->goalsHomeTeam.":".$value->result->goalsAwayTeam."</td>";
      $this->result .="</tr>";
    }
  }

  private function checkMatchDay(){
    $before = file_get_contents("../setting/recorder/before");
    if ($before == $this->matchday){
      return false;
    }else{
      file_put_contents("../setting/recorder/before",$this->matchday);
      return true;
    }
  }

  private function Contents(){
    $contents  =  "
    <html>
    <head>
    <title>SerieA Result</title>
    </head>
    <body>
    <table border=1>
    $this->result
    </table>
    <table border=1>
    $this->table
    </table>
    </body>
    </html>
    " ;
    return $contents;
  }

}


?>
