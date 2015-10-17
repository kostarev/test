<?php

Class Controller_Index Extends Controller_Base {

    function index() {

        $dota = Dota::me();
        $arr = $dota->start();

        if (isset($this->args[0])) {
            $match_id = (int) $this->args[0];
        }

        if (!empty($match_id)) {
            $steam_ids_array = Array();
            $match = $dota->get_match_by_id($match_id);
            foreach ($match['result']['players'] AS $key => $player) {
                if ($player['account_id'] == 4294967295) {
                    continue;
                }
                $steam_ids_array[$key] = $player['account_id'];
            }
            $profiles = $dota->get_user_profiles($steam_ids_array);
            foreach ($profiles AS $key => $profile) {
                $match['result']['players'][$key]['profile'] = $profile;
            }
            $this->des->set('arr', $arr['result']);
            $this->des->set('match', $match['result']);
        }

        $this->des->set('dota', $dota);
        $this->des->display('index');
    }

}

?>