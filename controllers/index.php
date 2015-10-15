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
     
        $this->des->set('dota', $dota);
        $this->des->display('index');
    }
}

?>