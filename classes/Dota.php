<?php
//https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=3FCAE426B6948F394EAE059B3DD96C12

class Dota{
    
    function start(){
        //$url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key='.API_KEY;
        $url = D.'/sys/cache/dota.json';
        $answer = file_get_contents($url);

        return json_decode($answer,true);
    }
    
    function get_match_by_id($match_id){
        $match_id = (int)$match_id;
      echo  $url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id='.$match_id.'&key='.API_KEY;
        $file = D.'/sys/cache/dota_match.json';
        $answer = file_get_contents($file);
        
        //file_put_contents($file, $answer);

        return json_decode($answer,true);
    }
    
}
?>
