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
         
        /*
        $heroes = $dota->get_heroes();
        $dir = D.'/data/portraits_webm';
        foreach($heroes AS $hero){
            $file = $dir.'/'.$hero['id'].'.webm';
            $file1 = D.'/data/portraits_png_50/'.$hero['id'].'.png';
            //if(is_file($file)){
            //    system(D.'/ffmpeg -i '.$file.' -an -ss 00:00:02 -r 1 -vframes 1 -s 50x50 -y '.$file1);
            //}
        }
        */
        
        $this->des->set('dota',$dota);
        $this->des->display('index');
    }

}

?>