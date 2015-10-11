<?php

Class Controller_Index Extends Controller_Base {

    function index() {

        $dota = Dota::me();
        $arr = $dota->start();

        if (isset($this->args[0])) {
            $match_id = (int) $this->args[0];
        }

        if (!empty($match_id)) {
            $match = $dota->get_match_by_id($match_id);
            $this->des->set('arr', $arr['result']);
            $this->des->set('match', $match['result']);
        }
        

        
        /*
        $file = D . '/npc_heroes.txt';
        $str = file_get_contents($file);
        
        $rrrr = json_decode($str);
        print_r($rrrr);
        $arr = explode('npc_dota_hero_', $str);

        $string = '';
        foreach ($arr AS $s) {
            preg_match('|([a-z]+)\"|', $s, $ggg);
            $hero = $ggg[1];
            preg_match('|"HeroID"([\s]+)\"([0-9]+)\"|', $s, $ggg);
            if (isset($ggg[2])) {
                $hero_id = (int) $ggg[2];


                preg_match('|"url"([\s]+)\"([^\s]+)\"|', $s, $ggg);
                if (isset($ggg[2])) {
                    $hero_name = trim($ggg[2]);

                    $string.= $hero_id . '|' . $hero . '|' . $hero_name . "\n";
                }
            }
        }

        //echo $string;
        echo '<pre>';
        //print_r($arr);
        echo '</pre>';
          */
         
        $heroes = $dota->get_heroes();
        $dir = D.'/data/portraits';
        foreach($heroes AS $hero){
            $file = $dir.'/npc_dota_hero_'.$hero['name'].'.webm';
            if(is_file($file)){
                rename($file, $dir.'/'.$hero['id']);
                system('sftowebm '.$dir.'/'.$hero['id']);
            }
        }
        
        $this->des->set('dota',$dota);
        $this->des->display('index');
    }

}

?>