<div>
    <p class="red">Внимание!</p>
    <p>Данный модуль предназначен исключительно для опытных пользователей. Неумелое использование модуля может привести в нерабочее состояние ваши модули, а так же различные части сайта.
        Прежде чем что-то делать, убедитесь, что Вы знаете, что делаете. Если Вы не знаете что произойдёт при нажатии той или иной кнопки, лучше её не нажимайте, а сначала узнайте её назначение.
    </p>
    <p>Данный модуль является удобным инструментом для создания и редактирования модулей сайта. Однако, любые действия которые можно сделать из этого модуля, можно сделать и без него вручную. 
        Для этого просто откройте файл модуля любым zip архиватором и редактируйте всё что угодно.</p>
    <div>
        <p>Для внесения изменений в модуль, следуйте данному алгоритму:</p>
        <ul>
            <li>Включите модуль</li>
            <li>Отредактируйте нужные файлы</li>
            <li>Нажмите "Сохранить изменения в модуле"</li>
        </ul>
        После этого, в архив модуля помещаются изменённые файлы. <br />
        Для добавления других файлов, ранее не находящихся внутри модуля или для удаления файлов из модуля, воспользуйтесь соответствующими ссылками.
    </div>
    <?if(!isset($_GET['add'])):?>
    <p><a href="?add#make_mod">Создать модуль</a></p>
    <?else:?>
    <a name="make_mod"></a>
    <p><a class="red" href="?">Отмена</a></p>
    <form method="post" action="?add#make_mod">
        <p><input type="text" name="fname"  placeholder="Имя файла" /><b>.smod</b></p>
        <p><input type="text" name="title"  placeholder="Название" /></p>
        <p><input type="text" name="autor"  placeholder="Автор" /></p>
        <p><input type="text" name="version" value="1.0" placeholder="Версия модуля" /></p>
        <p><input type="text" name="cms_version" value="" placeholder="Версия движка" /></p>
        <p><textarea name="description" style="width:98%;height:50px;" placeholder="Описание"></textarea></p>
        <p><input type="submit" value="Создать заготовку" /></p>
    </form>
    <?endif;?>

    <p></p>
    <?if($modules):?>
    <a name="mods"></a>
    <b>Выберите модуль</b>
    <form method="get" action="#mods">
        <select name="mod" OnChange="this.form.submit()">
            <?foreach($modules AS $mod):?>
            <option value="<?=$mod['fname'];?>" <?=($module['fname']==$mod['fname'])?'selected="selected"':'';?>><?=$mod['title'];?></option>
            <?endforeach;?>
        </select>
        <input type="submit" value="Ок" />
    </form>
    <?endif;?>

    <?if($module):?>
    <table class="sys" style="margin-top:20px;width:100%;">
        <tr><td>Название</td><td style="width:80%;"><?=$module['title'];?></td></tr>
        <tr><td>Файл</td><td><a href="<?=H;?>/panel/mastermod/download/<?=$module['fname'];?>"><?=$module['fname'];?></a></td></tr>
        <tr><td>Описание</td><td><?=$module['description'];?></td></tr>
        <tr><td>Автор</td><td><?=$module['autor'];?></td></tr>
        <tr><td>Версия</td><td><?=$module['version'];?></td></tr>
        <tr><td>Версия CMS</td><td><?=$module['cms_version'];?></td></tr>
        <tr <?if($module['installed']):?>class="back_green"<?endif;?>>
            <td>Вкл/Выкл</td>
            <td>
                <?if($module['installed']):?>
                <a href="<?=H;?>/panel/mastermod/uninstall/<?=$module['fname'];?>#mods">Выкл</a>
                <?else:?>
                <a href="<?=H;?>/panel/mastermod/install/<?=$module['fname'];?>#mods">Вкл</a>
                <?endif;?>
            </td>
        </tr>
        <?if($module['installed']):?>
        <tr>
            <td colspan="2">
                <form method="post" action="#">
                    <input type="submit" name="save" value="Сохранить изменения в модуле" class="red"/>
                </form>
            </td>
        </tr>
        <?endif;?>
        <?if($message):?>
        <tr>
            <td colspan="2">
                <?=$message;?>
            </td>
        </tr>
        <?endif;?>

        <!-- 
        <td><?if(!$mod['installed']):?><a title="Удалить" class="red" href="<?=H;?>/panel/modules/del/<?=$mod['fname'];?>">[X]</a><?endif;?></td> 
        -->

    </table>

    <?if($module['installed']):?>
    <style type="text/css" scoped="scoped">
        #mod_files div{margin:5px;}
        div.dir{margin:20px;}
        div.file{margin-left:20px;}
        .info,.id{display:none;}
        span.add{cursor: pointer}
        span.del{cursor: pointer; color:red;}
    </style>
    <script type="text/javascript">
        jQuery(function() {
        $('span.add').on('click', function(){
        if(this.id==''){
        $(this).attr('id', 'add_'+Math.floor(Math.random()*1001));
        }
    file = $('#'+this.id+' span.info').html();
    $.ajax({
    type: "POST",
    url: "?mod=<?=$module['fname'];?>&ajax=script",
    data: "add="+file,
    dataType: "script",
    success: function(msg){
    newid = Math.floor(Math.random()*1001);
    html = '<div id="file'+newid+'">'+file+' <span title="Удалить файл '+file+' из модуля" class="del" href="?mod=<?=$module['fname'];?>&amp;del='+file+'">[x]<span class="info">'+file+'</span><span class="id">'+newid+'</span></span></div>';
    $('#mod_files').append(html);
}
});
});
$('span.del').on('click', function(){
if(this.id==''){
$(this).attr('id', 'add_'+Math.floor(Math.random()*1001));
}
file = $('#'+this.id+' span.info').html();
id = $('#'+this.id+' span.id').html();
$.ajax({
type: "POST",
url: "?mod=<?=$module['fname'];?>&ajax=script",
data: "del="+file,
dataType: "script",
success: function(msg){  
$('#file'+id).hide();
}
});
});
});
    </script>
    <a name="site_files"></a>

    <div class="module_text">
        <h3>Файлы модуля</h3>
        <div id="mod_files">
            <?$i=0;foreach($mod_files AS $file):$i++;?>
            <div id="file<?=$i;?>"><?=$file;?> <span title="Удалить файл <?=$file;?> из модуля" class="del" href="?mod=<?=$module['fname'];?>&amp;del=<?=$file;?>">[x]<span class="info"><?=$file;?></span><span class="id"><?=$i;?></span></span></div>
            <?endforeach;?>
        </div>
    </div>


    <?if(!$site_files):?>
    <a href="?mod=<?=$module['fname'];?>&amp;add_files#site_files">Добавить файлы в модуль</a>
    <?else:?>
    <p><a href="?mod=<?=$module['fname'];?>#site_files" class="red">Отмена</a></p>
    <?
    //Вывод html дерева файлов
    function show_files_tree($arr){
    $html = '';
    foreach($arr AS $key => $val){
    if($val['type']=='file'){
    $html.='<div class="file">'.$val['name'].'<span class="add green" title="Добавить '.$val['name'].' в модуль"> [+] <span class="info">'.$key.'</span></span></div>';
    }
    elseif($val['type']=='dir'){
    $html.= '<div class="dir"><span class="open">'.$val['name'].'</span><span class="info">'.$key.'</span>';
    $html.= '<div class="file close">'.show_files_tree($val['child']).'</div>';
    $html.='</div>';
    }
    }
    return $html;
    }
    ?>
    Выберите файлы для добавления
    <div style="border:solid 1px #5090F7;padding:5px;"><?=show_files_tree($site_files);?></div>
    <?endif;?>



    <?if(!isset($_GET['ini_edit'])):?>
    <p><a href="?mod=<?=$module['fname'];?>&amp;ini_edit#site_files">Редактировать info.ini</a></p>
    <?else:?>
    <p><a class="red" href="?mod=<?=$module['fname'];?>&amp;#site_files">Отмена</a></p>
    <form method="post" action="#mods">
        <p><input type="text" name="title" value="<?=$module['title'];?>" placeholder="Название" /></p>
        <p><input type="text" name="autor" value="<?=$module['autor'];?>" placeholder="Автор" /></p>
        <p><input type="text" name="version" value="<?=$module['version'];?>" placeholder="Версия модуля" /></p>
        <p><input type="text" name="cms_version" value="<?=$module['cms_version'];?>" placeholder="Версия движка" /></p>
        <p><textarea name="description" style="width:98%;height:50px;" placeholder="Описание"><?=$module['description'];?></textarea></p>
        <p><input type="submit" value="Сохранить" /></p>
    </form>
    <?endif;?>
    <?endif;?>

    <?if($files):?>
    <h3>Проверка на конфликты с другими модулями</h3>
    <?foreach($files AS $file):?>
    <p><?=$file['name']?> 
        <?if($file['conflict']):?>[<span class="red">Конфликт с <?=$file['conflict'];?></span>]
        <?elseif($file['replace']):?>[<span class="siren">Замена</span>]
        <?else:?>[<span class="green">Ok</span>]<?endif;?>

    </p>
    <?endforeach;?>
    <p><a href="<?=H;?>/panel/modules/installed">Назад</a></p>
    <?endif;?>

    <?endif;?>
</div>