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
    $this->getResult();
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
    $this->result = "<tr><th>".$this->dict->getDict('Match Date')."(".$this->dict->getDict('timezone').")</th><th>".$this->dict->getDict('Team')."</th><th>".$this->dict->getDict('Result')."</th></tr>";
    foreach ($fixtures->fixtures as $value){
      $this->result .= "<tr>";
      $this->result .= "<td>".date("Y-m-d H:i",strtotime("+8 hour",strtotime($value->date)))."</td>";
      $this->result .= "<td>".$this->dict->getDict($value->homeTeamName)." : ".$this->dict->getDict($value->awayTeamName)."</td>";
      $this->result .=($value->status=="FINISHED")? "<td>".$value->result->goalsHomeTeam.":".$value->result->goalsAwayTeam."</td>":"<td>".$this->dict->getDict('not start')."</td>";
      $this->result .="</tr>";
    }
  }

  //@unused
  private function checkMatchDay(){
    $before = file_get_contents("../setting/recorder/before");
    if ($before == $this->matchday){
      return false;
    }
    file_put_contents("../setting/recorder/before",$this->matchday);
    return true;
  }

  private function Contents(){
    $contents  =  "
    <html>
    <head>
    <title>SerieA Result</title>
    </head>
    <body>
    <p>".$this->dict->getDict('MatchDay').":".$this->matchday."</p>
    <table border=1>
    $this->result
    </table>
    <p>".$this->dict->getDict('Standing')."</p>
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
