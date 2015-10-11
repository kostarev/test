<div>
    <?if($kidals):?>
    <?if($join):?>
    <div class="block">
        <div class="block">
            <b>В чёрном списке <?=implode(', ',$kidals['url']);?></b><br />
            <?if($kidals['wmid']):?><p><b>Wmid:</b>
                <?foreach($kidals['wmid'] AS $wmid):?>
                <a target="_block" href="http://passport.webmoney.ru/asp/certview.asp?wmid=<?=$wmid;?>"><?=$wmid;?></a>,  
                <?endforeach;?>
            </p>
            <?endif;?>

            <?if($kidals['email']):?><p><b>Email:</b>
                <?=implode(', ',$kidals['email']);?>
            </p>
            <?endif;?>

            <?if($kidals['skype']):?><p><b>Skype:</b>
                <?=implode(', ',$kidals['skype']);?>
            </p>
            <?endif;?>

            <?if($kidals['icq']):?><p><b>ICQ:</b>
                <?=implode(', ',$kidals['icq']);?>
            </p>
            <?endif;?>

            <?if($kidals['name']):?><p><b>Имя:</b>
                <?=implode(', ',$kidals['name']);?>
            </p>
            <?endif;?>

            <?if($kidals['sites']):?><p><b>Сайты:</b>
                <?=implode(', ',$kidals['sites']);?>
            </p>
            <?endif;?>

            <?if($kidals['descr']):?><p><b>Характеристика:</b>
                <?=implode(', ',$kidals['descr']);?>
            </p>
            <?endif;?>
        </div>
        <?else:?>
        
        <?foreach($kidals AS $kidala):?>
        <div class="block">
            <b>В чёрном списке <?=$kidala['url'];?></b><br />
            <?if($kidala['wmid']):?><p><b>Wmid:</b>
                <?foreach($kidala['wmid'] AS $wmid):?>
                <a target="_block" href="http://passport.webmoney.ru/asp/certview.asp?wmid=<?=$wmid;?>"><?=$wmid;?></a>,  
                <?endforeach;?>
            </p>
            <?endif;?>

            <?if($kidala['email']):?><p><b>Email:</b>
                <?=implode(', ',$kidala['email']);?>
            </p>
            <?endif;?>

            <?if($kidala['skype']):?><p><b>Skype:</b>
                <?=implode(', ',$kidala['skype']);?>
            </p>
            <?endif;?>

            <?if($kidala['icq']):?><p><b>ICQ:</b>
                <?=implode(', ',$kidala['icq']);?>
            </p>
            <?endif;?>

            <?if($kidala['name']):?><p><b>Имя:</b>
                <?=implode(', ',$kidala['name']);?>
            </p>
            <?endif;?>

            <?if($kidala['sites']):?><p><b>Сайты:</b>
                <?=implode(', ',$kidala['sites']);?>
            </p>
            <?endif;?>

            <?if($kidala['descr']):?><p><b>Характеристика:</b>
                <?=$kidala['descr'];?>
            </p>
            <?endif;?>
        </div>
        <?endforeach;?>
        <?endif;?>
        <?elseif(!empty($_GET)):?>
        Данные не найдены в чёрных списках
        <?endif;?>

    </div>