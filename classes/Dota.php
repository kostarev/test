<?php

//https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=3FCAE426B6948F394EAE059B3DD96C12

class Dota extends CMS_System {

    protected $heroes;
    static protected $instance = null;

    static public function me() {
        if (is_null(self::$instance))
            self::$instance = new Dota();
        return self::$instance;
    }

    protected function __construct() {
        parent::__construct();
        $res = $this->db->query("SELECT * FROM dota_heroes ORDER BY id;");
        $this->heroes = $res->fetchAll();
    }

    function start() {
        //$url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key='.API_KEY;
        $url = D . '/sys/cache/dota.json';
        $answer = file_get_contents($url);

        return json_decode($answer, true);
    }

    function get_match_by_id($match_id) {
        $match_id = (int) $match_id;
        $url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id=' . $match_id . '&key=' . API_KEY;
        $file = D . '/sys/cache/dota_match_' . $match_id . '.json';
        if (!is_file($file)) {
            $answer = file_get_contents($url);
            file_put_contents($file, $answer);
        } else {
            $answer = file_get_contents($file);
        }
        return json_decode($answer, true);
    }

    function get_hero_url($hero_id) {
        $hero_id = (int) $hero_id;
        if (isset($this->heroes[$hero_id])) {
            return str_replace('_', ' ', $this->heroes[$hero_id]['url']);
        }
    }

    function get_heroes() {
        return $this->heroes;
    }

    function get_heroes_by_api() {
        $url = 'https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=' . API_KEY;
        $result = file_get_contents($url);
        $arr = json_decode($result, true);
        $heroes = $arr['result']['heroes'];
        return $heroes;
    }

}

?>
