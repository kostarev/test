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

        $heroes = $dota->get_heroes();
        $dir1 = D.'/data/portraits/png_256';
        $dir2 = D.'/data/portraits/png_50';
        foreach ($heroes AS $h){
            $file1 = $dir1.'/'.$h['id'].'.png';
            $file2 = $dir2.'/'.$h['id'].'.png';
            if(is_file($file1)){
                //system(D.'/ffmpeg -i '.$file1.' -s 50x50 '.$file2);
            }
        }


        $this->des->set('dota', $dota);
        $this->des->display('index');
    }
}

?>