<div>
    <div><b>Матч: <?=$match['match_id'];?></b></div>
    <div>
        <?if($match['radiant_win']):?>Победа света
        <?else:?>Победа тьмы<?endif;?>
    </div>
    <div>Длительность: <?=Func::sec2human($match['duration']);?></div>
    <div>Начало: <?=Func::unix2human($match['start_time']);?></div>
    <div>Конец: <?=Func::unix2human($match['start_time']+$match['duration']);?></div>
    <div>tower_status_radiant: <?=$match['tower_status_radiant'];?></div>
    <div>tower_status_dire: <?=$match['tower_status_dire'];?></div>
    <div>barracks_status_radiant: <?=$match['barracks_status_radiant'];?></div>
    <div>barracks_status_dire: <?=$match['barracks_status_dire'];?></div>
    <div>cluster: <?=$match['cluster'];?></div>
    <div>first_blood_time: <?=$match['first_blood_time'];?></div>
    <div>lobby_type: <?=$match['lobby_type'];?></div>
    <div>human_players: <?=$match['human_players'];?></div>
    <div>leagueid: <?=$match['leagueid'];?></div>
    <div>positive_votes: <?=$match['positive_votes'];?></div>
    <div>negative_votes: <?=$match['negative_votes'];?></div>
    <div>game_mode: <?=$match['game_mode'];?></div>
    <div>engine: <?=$match['engine'];?></div>
    <div>Запись: <?if($match['replay_salt']):?><a href="http://replay<?=$match['cluster'];?>.valve.net/570/<?=$match['match_id'];?>_<?=$match['replay_salt'];?>.dem.bz2">http://replay<?=$match['cluster'];?>.valve.net/570/<?=$match['match_id'];?>_<?=$match['replay_salt'];?>.dem.bz2</a>
        <?else:?>Отсутствует<?endif;?>
    </div>


    <div>
        Игроки
        <table class='sys'>
            <tr>
                <th>№</th>
                <th>account_id</th>
                <th>player_slot</th>
                <th>hero_id</th>
                <th>items</th>
                <th>kills</th>
                <th>deaths</th>
                <th>assists</th>
                <th>leaver_status</th>
                <th>gold</th>
                <th>last_hits</th>
                <th>denies</th>
                <th>gold_per_min</th>
                <th>xp_per_min</th>
                <th>gold_spent</th>
                <th>hero_damage</th>
                <th>tower_damage</th>
                <th>hero_healing</th>
                <th>level</th>
                <th>ability_upgrades</th>
            </tr>
            <?foreach($match['players'] AS $key =>$val):?>
            <tr>
                <td><?=$key;?></td>
                <td><?=$val['account_id'];?></td>
                <td><?=$val['player_slot'];?></td>
                <td><?=$dota->get_hero_url($val['hero_id']);?>
                    <img src='/data/portraits_png_50/<?=$val['hero_id'];?>.png' alt="<?=$dota->get_hero_url($val['hero_id']);?>"/>
                </td>
                <td><?=$val['items'];?></td>
                <td><?=$val['kills'];?></td>
                <td><?=$val['deaths'];?></td>
                <td><?=$val['assists'];?></td>
                <td><?=$val['leaver_status'];?></td>
                <td><?=$val['gold'];?></td>
                <td><?=$val['last_hits'];?></td>
                <td><?=$val['denies'];?></td>
                <td><?=$val['gold_per_min'];?></td>
                <td><?=$val['xp_per_min'];?></td>
                <td><?=$val['gold_spent'];?></td>
                <td><?=$val['hero_damage'];?></td>
                <td><?=$val['tower_damage'];?></td>
                <td><?=$val['hero_healing'];?></td>
                <td><?=$val['level'];?></td>
                <td><?=$val['ability_upgrades'];?></td>
            </tr>
            <?endforeach;?>
        </table>
    </div>

    <? /*

    <div>
    <table class='sys'>
    <tr>
    <th style='width:50px;' >№</th>
    <th style='width:50px;'>match_id</th>
    <th>match_seq_num</th>
    <th>start_time</th>
    <th>lobby_type</th>
    <th style='width:50px;'>radiant_team_id</th>
    <th style='width:50px;'>dire_team_id</th>
    <th style='width:80%;'>players</th>
    </tr>
    <?foreach($arr['matches'] AS $key =>$val):?>
    <tr>
        <th><?=$key+1;?></th>
        <th><?=$val['match_id'];?></th>
        <th><?=$val['match_seq_num'];?></th>
        <th><?=$val['start_time'];?></th>
        <th><?=$val['lobby_type'];?></th>
        <th><?=$val['radiant_team_id'];?></th>
        <th><?=$val['dire_team_id'];?></th>
        <th>
            <?foreach($val['players'] AS $k => $player):?>
    <div>
        account_id = <?=$player['account_id'];?><br />
        player_slot= <?=$player['player_slot'];?><br />
        hero_id = <?=$player['hero_id'];?><br /><br />
    </div>
    <?endforeach;?>
</th>
</tr>
<?endforeach;?>
</table>
</div>

/*?>
</div>
