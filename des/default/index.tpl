<div>
    <div>
        <table class='sys'>
            <tr>
                <th>Матч</th>
                <th>match_seq_num</th>
                <th>Начало матча</th>
            </tr>
            <?foreach($history['matches'] AS $key =>$val):?>
            <tr>
                <td>
                    <a href='/match/<?=$val['match_id'];?>'>
                       <?foreach($val['players'] AS $k => $player):?>
                       <?if(Dota::me()->MAKE_64_BIT($player['account_id'])==$this->user['steamid']):?>
                       <img class="hero_icon" src='/data/heroes/<?=$dota->heroes[$player['hero_id']]['title'];?>.png' alt="<?=$dota->get_hero_url($player['hero_id']);?>"/>
                         <br /><?=$val['match_id'];?>
                        <?break;endif;?>
                        <?endforeach;?>
                    </a>
                </td>
                <td><?=$val['match_seq_num'];?></td>
                <td><?=Func::unix2human($val['start_time']);?></td>
            </tr>
            <?endforeach;?>
        </table>
    </div>

</div>