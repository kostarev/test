<?php

define("STEAM_ID_UPPER_32_BITS", "00000001000100000000000000000001");

//https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=3FCAE426B6948F394EAE059B3DD96C12

class Dota extends CMS_System {

    public $heroes, $items, $spells;
    static protected $instance = null;

    static public function me() {
        if (is_null(self::$instance))
            self::$instance = new Dota();
        return self::$instance;
    }

    protected function __construct() {
        parent::__construct();
    }

    function init_heroes($heroesArray) {
        foreach ($heroesArray AS $key => $val) {
            if (isset($this->heroes[$val])) {
                unset($heroesArray[$key]);
            }
        }
        if (empty($heroesArray)) {
            return;
        }
        $in = str_repeat('?,', count($heroesArray) - 1) . '?';
        $res = $this->db->prepare("SELECT * FROM dota_heroes WHERE id IN ($in) ORDER BY id;");
        $res->execute($heroesArray);
        $tmp = $res->fetchAll();
        foreach ($tmp AS $arr) {
            $this->heroes[$arr['id']] = $arr;
        }
    }

    function init_spells($spellsArray) {
        foreach ($spellsArray AS $key => $val) {
            if (isset($this->spells[$val])) {
                unset($spellsArray[$key]);
            }
        }
        if (empty($spellsArray)) {
            return;
        }
        $in = str_repeat('?,', count($spellsArray) - 1) . '?';
        $res = $this->db->prepare("SELECT * FROM dota_abilities WHERE id IN ($in) ORDER BY id;");
        $res->execute($spellsArray);
        $tmp = $res->fetchAll();
        foreach ($tmp AS $arr) {
            $this->spells[$arr['id']] = $arr;
        }
    }

    function init_items($itemsArray) {
        foreach ($itemsArray AS $key => $val) {
            if (isset($this->items[$val])) {
                unset($itemsArray[$key]);
            }
        }
        if (empty($itemsArray)) {
            return;
        }
        $in = str_repeat('?,', count($itemsArray) - 1) . '?';
        $res = $this->db->prepare("SELECT * FROM dota_items WHERE id IN ($in) ORDER BY id;");
        $res->execute($itemsArray);
        $tmp = $res->fetchAll();
        foreach ($tmp AS $arr) {
            $this->items[$arr['id']] = $arr;
        }
    }

    function start() {
        //$url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key='.STEAM_API_KEY;
        $url = D . '/sys/cache/dota.json';
        $answer = file_get_contents($url);
        return json_decode($answer, true);
    }

    function get_match_by_id($match_id) {
        $match_id = (int) $match_id;
        $url = 'https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id=' . $match_id . '&key=' . STEAM_API_KEY;
        $file = D . '/sys/cache/matches/' . $match_id . '.json';
        if (!is_file($file)) {
            $answer = file_get_contents($url);
            file_put_contents($file, $answer);
        } else {
            $answer = file_get_contents($file);
        }
        $arr = json_decode($answer, true);

        $match = $arr['result'];

        $heroes = Array();
        $spells = Array();
        $items = Array();

        foreach ($match['players'] AS $val) {
            $heroes[] = $val['hero_id'];
            for ($i = 0; $i <= 5; $i++) {
                if (isset($val['item_' . $i])) {
                    $items[] = $val['item_' . $i];
                }
            }
            foreach ($val['ability_upgrades'] AS $ab) {
                $spells[] = $ab['ability'];
            }
        }

        $this->init_heroes($heroes);
        $this->init_spells($spells);
        $this->init_items($items);

        return $match;
    }

    function get_hero_url($hero_id) {
        $hero_id = (int) $hero_id;
        if (isset($this->heroes[$hero_id])) {
            return str_replace('_', ' ', $this->heroes[$hero_id]['url']);
        }
    }

    function get_item_name($item_id) {
        $item_id = (int) $item_id;
        if (isset($this->items[$item_id])) {
            return $this->items[$item_id]['localized_name'];
        }
    }

    function get_heroes() {
        return $this->heroes;
    }

    function get_items() {
        return $this->items;
    }

    function get_spells() {
        return $this->spells;
    }

    function get_heroes_by_api() {
        $url = 'https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key='.STEAM_API_KEY;
        $result = file_get_contents($url);
        $arr = json_decode($result, true);
        $heroes = $arr['result']['heroes'];
        return $heroes;
    }

    function get_items_by_api() {
        $url = 'https://api.steampowered.com/IEconDOTA2_570/GetGameItems/V001/?key=' . STEAM_API_KEY . '&language=Ru';
        $result = file_get_contents($url);
        $arr = json_decode($result, true);
        $items = $arr['result']['items'];
        return $items;
    }

    function getAccountID($steam_id) {
        $account_id = substr(decbin($steam_id), 32);
        $account_id = bindec($account_id);
        return $account_id;
    }

    function GET_32_BIT($ID_64) {
        $upper = gmp_mul(bindec(STEAM_ID_UPPER_32_BITS), "4294967296");
        return gmp_strval(gmp_sub($ID_64, $upper));
    }

    // creates a 64-bit steam id from the lower 32-bits
    function MAKE_64_BIT($ID_32, $hi = false) {
        if ($hi === false) {
            $hi = bindec(STEAM_ID_UPPER_32_BITS);
        }

        // workaround signed/unsigned braindamage on x32
        $hi = sprintf("%u", $hi);
        $ID_32 = sprintf("%u", $ID_32);

        return gmp_strval(gmp_add(gmp_mul($hi, "4294967296"), $ID_32));
    }

    function get_user_profile_xml($steam_id) {
        if (strlen($steam_id) < 15) {
            $steam_id = $this->MAKE_64_BIT($steam_id);
        }
        $file = D . '/sys/cache/users/' . $steam_id . '.xml';
        if (!is_file($file)) {
            $url = 'http://steamcommunity.com/profiles/' . $steam_id . '/?xml=1';
            $xml = file_get_contents($url);
            file_put_contents($file, $xml);
        }
        $profile = simplexml_load_file($file);
        return $profile;
    }

    function get_user_profile($steam_id) {
        if (strlen($steam_id) < 15) {
            $steam_id = $this->MAKE_64_BIT($steam_id);
        }

        $url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . STEAM_API_KEY . '&steamids=' . $steam_id;
        $file = D . '/sys/cache/users/' . $steam_id . '.json';
        if (!is_file($file)) {
            $result = file_get_contents($url);
            file_put_contents($file, $result);
        } else {
            $result = file_get_contents($file);
        }

        $arr = json_decode($result, true);
        $profile = $arr['response']['players'][0];
        return $profile;
    }

    function get_user_profiles($steam_ids_array) {
        $profiles = Array();
        $urls = Array();
        $files = Array();
        foreach ($steam_ids_array AS $key => $steam_id) {
            if (strlen($steam_id) < 15) {
                $steam_id = $this->MAKE_64_BIT($steam_id);
            }
            $files[$key] = D . '/sys/cache/users/' . $steam_id . '.json';
            if (is_file($files[$key])) {
                $result = file_get_contents($files[$key]);
                $arr = json_decode($result, true);
                $profiles[$key] = $arr['response']['players'][0];
            } else {
                $urls[$key] = 'http://api.steampowered.com/ISteamUser/GetPlayerSSTEAM_API_KEYs/v0002/?key=' . API_KEY . '&steamids=' . $steam_id;
            }
        }

        if (!empty($urls)) {

            foreach ($urls AS $key => $url) {
                $ch[$key] = curl_init();
                // устанавливаем URL и другие соответствующие опции
                curl_setopt($ch[$key], CURLOPT_URL, $url);
                curl_setopt($ch[$key], CURLOPT_HEADER, 0);
                curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, 1);
            }

            //создаем набор дескрипторов cURL
            $mh = curl_multi_init();

            //добавляем дескрипторы
            foreach ($ch AS $chanel) {
                curl_multi_add_handle($mh, $chanel);
            }

            $active = null;
            //запускаем дескрипторы
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($active && $mrc == CURLM_OK) {
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
            //закрываем все дескрипторы
            foreach ($ch AS $chanel) {
                curl_multi_remove_handle($mh, $chanel);
            }
            curl_multi_close($mh);

            //Получаем результаты
            foreach ($ch AS $key => $chanel) {
                $result = curl_multi_getcontent($chanel);
                file_put_contents($files[$key], $result);
                $arr = json_decode($result, true);
                $profiles[$key] = $arr['response']['players'][0];
            }
        }
        return $profiles;
    }

}

?>
