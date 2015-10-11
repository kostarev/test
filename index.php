<?php

session_start();
//Начало генерации страницы. Конец и подсчёт времени в Template->__destroy()
$_SESSION['start_gen_time'] = microtime(true);

error_reporting(E_ALL);


// Константы:
define('D', str_replace('\\', '/', realpath(dirname(__FILE__))));
define('H', str_replace($_SERVER['DOCUMENT_ROOT'], 'http://' . $_SERVER['HTTP_HOST'], D));
define('TIME', time());
//Определяем глобальный массив
$registry = Array();

// Автозагрузка классов---------
function __autoload($class_name) {

    $file = D . '/classes/' . $class_name . '.php';
    if (!is_file($file)) {
        return false;
    }
    include ($file);
}

//---------------------------
//Подключение к БД
include D . '/sys/config.php';

//Класс кэширования
$registry['cache'] = Cache::me();


try {
    $db = new DebugPDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $db->setAttribute(PDO :: ATTR_DEFAULT_FETCH_MODE, PDO :: FETCH_ASSOC);
    $db->log_on();
    $db->cache = &$registry['cache'];
    $db->query("SET NAMES utf8;");
    $registry['db'] = $db;
} catch (Exception $e) {
    echo 'Ошибка соединения с базой данных';
    exit;
}


//Считывание настроек из базы----------------------
$raw_config = Array();
$config = Array();
$raw_conf_array = Array();
$conf_dirs = Array(0);

if ($row = $db->get("SELECT * FROM config ORDER BY mother;", 60)) {
    foreach ($row AS $val) {
        if ($val['value'] == 'directory' AND $val['mother'] == '0') {
            $conf_dirs[$val['name']] = $val;
        } else {
            $raw_config[] = $val;
        }
    }
}


foreach ($raw_config AS $val) {
    if (isset($conf_dirs[$val['mother']]) AND $val['mother']) {
        $config[$val['mother']][$val['name']] = $val['value'];
        $raw_conf_array[$val['mother']][$val['name']] = $val;
    } else {
        $config[$val['name']] = $val['value'];
        $raw_conf_array[$val['name']] = $val;
    }
}

//Настройки системы
$registry['conf'] = $config;
$registry['conf_array'] = $raw_conf_array;
$registry['conf_dirs'] = $conf_dirs;

unset($raw_config);
unset($config);
unset($raw_conf_array);
unset($conf_dirs);

//------------------------------------------------------

if (!$registry['conf']['developer']['sql_table']) {
    $db->log_off();
}

//Считывание групп и доступов из базы---------
if ($row = $db->get("SELECT * FROM actions;", 10)) {
    foreach ($row AS $val) {
        $registry['actions'][$val['id']] = $val;
    }
}



if ($row = $db->get("SELECT * FROM groups;", 10)) {
    foreach ($row AS $val) {
        $actions_arr = explode(',', $val['actions']);
        foreach ($actions_arr AS $act_id) {
            if (isset($registry['actions'][$act_id])) {
                $val['actions_arr'][$registry['actions'][$act_id]['name']] = $registry['actions'][$act_id];
            }
        }

        $registry['groups'][$val['name']] = $val;
    }
}

//-------------------------------------------
//Предыдущий посещённый адрес сайта (используется для ссылки "Назад")--	
if (!empty($_SERVER['HTTP_REFERER']) AND substr_count($_SERVER['HTTP_REFERER'], H)) {
    $registry['back_url'] = htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'utf-8');
}
if (empty($registry['back_url'])) {
    $registry['back_url'] = H;
}
//----------------------------------------------------------------------
//Создаём пользователя
$User = new User();
$registry['user'] = $User;
$User->auth();

//Класс отображения
$des = new Template();
$registry['des'] = $des;

//Загружаем router
$router = Router::me();
$registry['router'] = $router;

//Устанавливаем папку контроллеров
$router->setPath(D . '/controllers');
$router->delegate();
?>