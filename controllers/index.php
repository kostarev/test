<?php

Class Controller_Index Extends Controller_Base {

    function index() {

        $dota = Dota::me();
        if ($this->user['id']) {
            $arr['account_id'] = $this->user['steamid'];
            $arr['matches_requested'] = 5;
            $history = $dota->get_match_history($arr);

            $heroes = Array();
            foreach ($history['matches'] AS $match) {
                foreach ($match['players'] AS $player) {
                    if (Dota::me()->MAKE_64_BIT($player['account_id']) == $this->user['steamid']) {
                        $heroes[] = $player['hero_id'];
                    }
                }
            }

            $dota->init_heroes($heroes);

            $this->des->set('dota', $dota);
            $this->des->set('history', $history);
            $this->des->display('index');
        }
    }

}

?>