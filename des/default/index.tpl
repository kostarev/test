<div>

    <style>
        table.match th{background-color: #9999ff;padding:8px; text-align: center;}
        table.match td{background-color: #ccccff; text-align: center; pargin:0px;margin:0px;}
        tr.dire td{background-color:#8B7E7E;}
        tr.radiant td{background-color:#C3CB90 ;}
        table.match a{color:#231D6D;}
        table.match a:hover{text-decoration:underline;}
        table.match .leaver{color:#702F1A; font-size:80%;}
        table.match th span{text-decoration:underline;text-decoration-style:dotted;}
        table.match .hero_icon{width:50px;}
        table.match .items img{width:50px;}
    </style>

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
        <table class='match'>
            <tr>
                <th>&nbsp;</th>
                <th>Игрок</th>
                <th><span title="Уровень">Ур</span></th>
                <th><span title="Убийств">Уб</span</th>
                <th><span title="Смертей">См</span></th>
                <th><span title="Помощь">П</span></th>
                <th><span title="Золото">З</span></th>
                <th><span title="Добито крипов">Lh</span></th>
                <th><span title="Не отдал крипов">D</span></th>
                <th><span title="Золота в минуту">З/м</span></th>
                <th><span title="Опыта в минуту">О/м</span></th>
                <th><span title="Золота потрачено">ЗП</span></th>
                <th><span title="Нанесено урона вражеским героям">Ур.Г</span></th>
                <th><span title="Нанесено урона башням">Ур.Б</span></th>
                <th><span title="Исцеление героев">Исц</span></th>
                <th>Прокачка навыков</th>
                <th>Предметы</th>
            </tr>
            <?foreach($match['players'] AS $key =>$val):?>
            <tr class='<?=($val['player_slot']<128)?'radiant':'dire';?>'>
                <td>
                    <img class="hero_icon" src='/data/heroes/<?=$dota->heroes[$val['hero_id']]['title'];?>.png' alt="<?=$dota->get_hero_url($val['hero_id']);?>"/>
                         <!-- <video class="portrait" id="port<?=$val['hero_id'];?>" style="width:80px;" src="/data/portraits/webm/<?=$val['hero_id'];?>.webm" autoplay="autoplay" loop="loop"></video>
                            !-->
                </td>
                <td>
                    <?if($val['account_id']==4294967295):?>Скрыт<?else:?>
                    <a href="/profile/<?=$val['account_id'];?>">
                        <img src="<?=$val['profile']['avatar'];?>" alt="<?=$val['profile']['personaname'];?>" /><br />
                        <?=$val['profile']['personaname'];?></a>
                    <?endif;?>

                    <?=$val['leaver_status']?'<div class="leaver">Покинул игру</div>':'';?>
                </td> 
                <td><?=$val['level'];?></td>
                <td><?=$val['kills'];?></td>
                <td><?=$val['deaths'];?></td>
                <td><?=$val['assists'];?></td>
                <td><?=$val['gold'];?></td>
                <td><?=$val['last_hits'];?></td>
                <td><?=$val['denies'];?></td>
                <td><?=$val['gold_per_min'];?></td>
                <td><?=$val['xp_per_min'];?></td>
                <td><?=$val['gold_spent'];?></td>
                <td><?=$val['hero_damage'];?></td>
                <td><?=$val['tower_damage'];?></td>
                <td><?=$val['hero_healing'];?></td>
                <td>
                    
                </td>
                <td class="items">
                    <?for($i=0;$i<6;$i++):
                    if(!$val['item_'.$i])continue;
                    ?>
                    <img src="/data/items/<?=$dota->items[$val['item_'.$i]]['title'];?>.png" title="<?=$dota->items[$val['item_'.$i]]['localized_name'];?>"/>
                    <?endfor;?>
                </td>
            </tr>
            <tr><td colspan="17">
                    <?foreach($val['ability_upgrades'] AS $abUp):?>
                    <?=$spells[$abUp['ability']]['name'];?>
                    <?=$abUp['time'];?>
                    <?=$abUp['level'];?><br />
                    <?endforeach;?>
                    <pre><?//print_r($val);?></pre></td></tr>
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
