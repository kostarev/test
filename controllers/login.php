<?php

Class Controller_login Extends Controller_Base {

    public function __construct($args) {
        parent::__construct($args);
    }

    function registration() {
        if ($this->user['id']) {
            $this->error('Вы уже зарегистрированы');
        }

        $captcha = new Captcha();
        $this->des->set('captcha', $captcha);

        if (!$this->conf['reg']['on']) {
            $this->error('Регистрация закрыта');
        }


        //Ajax Проверка занятости логина
        if (isset($_POST['check_login'])) {
            $this->des->auto_head = false;
            //Длина логина
            if (mb_strlen($_POST['check_login'], 'UTF-8') < 3 OR mb_strlen($_POST['check_login'], 'UTF-8') > 10) {
                $str = '<span class="red">Длина от 3х до 10и символов.</span>';
            } else {
                $res = $this->db->prepare("SELECT login FROM users WHERE login=?;");
                $res->execute(Array($_POST['check_login']));
                if ($row = $res->fetch()) {
                    $str = '<span class="red">Уже занят!</span>';
                } else {
                    //валидация логина
                    if (!Func::valid_login($_POST['check_login'])) {
                        $str = '<span class="red">Запрещённые символы</span>';
                    } else {
                        $str = '<span class="green">Свободен</span>';
                    }
                }
            }
            echo "$('#check-login').html('$str');";
            exit;
        }

        //Обработка формы------
        if (isset($_POST['login'])) {
            $error = Array();
            $this->des->set('title', 'Регистрация');

            $_POST['login'] = trim($_POST['login']);
            $_POST['pas'] = trim($_POST['pas']);

            //Сохраняем поля формы
            $_SESSION['reg']['login'] = $_POST['login'];
            $_SESSION['reg']['email'] = $_POST['email'];
            $_SESSION['reg']['pas'] = $_POST['pas'];
            $_SESSION['reg']['repas'] = $_POST['repas'];

            if ($this->conf['reg']['captcha']) {
                if (!$captcha->is_access($_POST['captcha'])) {
                    $error[] = 'Не верно введены символы с картинки';
                }
            }

            //Сверка паролей
            if ($_POST['pas'] <> $_POST['repas']) {
                $error[] = 'Пароли не совпадают';
            }

            //Длина пароля
            if (mb_strlen($_POST['pas'], 'utf-8') < 5) {
                $error[] = 'Длина пароля должна быть не менее 5и символов.';
            }

            //Длина логина
            if (mb_strlen($_POST['login'], 'utf-8') < 3) {
                $error[] = 'Длина логина должна быть не менее 3х символов.';
            }

            //валидация логина
            if (!Func::valid_login($_POST['login'])) {
                $error[] = 'Запрещённые символы в поле Login! Разрешены только буквы русского и латинского алфавита и цифры.';
            }

            if ($this->conf['reg']['email']) {
                if ($this->conf['reg']['email_must']) {
                    if (empty($_POST['email'])) {
                        $error[] = 'Поле email - обязательно для заполнения';
                    }
                }

                if (!empty($_POST['email']) AND ! Func::valid_email($_POST['email'])) {
                    $error[] = 'Не верно заполнено поле Email.';
                }
            }

            //Если нет ошибок, регистрация
            if (!$error) {

                try {
                    $reg_arr = SiteWrite::me()->registration($_POST);

                    if ($this->conf['reg']['email_must']) {
                        $this->loc(H . '/login/email_confirm');
                    }

                    //Авторизируем пользователя
                    $_SESSION['user_id'] = $reg_arr['id'];

                    //Пишем куки-----
                    setcookie('id', $reg_arr['id'], time() + 3600 * 24 * 30, '/');
                    setcookie('p', $reg_arr['pas'], time() + 3600 * 24 * 30, '/');
                    //--------------


                    $this->loc(H . '/login/success');
                } catch (Exception $e) {
                    $error[] = $e->getMessage();
                }
            }

            //Заполняем сохранённые поля формы
            if (!empty($_SESSION['reg'])) {
                foreach ($_SESSION['reg'] AS $key => $val) {

                    $this->des->set($key, $val);
                }
            }

            //Вывод ошибок
            if ($error) {
                $this->error($error, false);
            }
        }
        //---------------------

        $this->des->set('registration', true);
        $this->des->display('login');
    }

    function success() {
        $this->des->set('title', 'Успех');
        $this->des->set('success', true);
        $this->des->display('login');
    }

    function email_confirm() {
        $this->des->set('title', 'Подтверждение');
        if (isset($this->args[0])) {
            $code = $this->args[0];
            try {
                $reg_arr = SiteWrite::me()->email_confirm($code);
                //Авторизируем пользователя
                $_SESSION['user_id'] = $reg_arr['id'];
                //Пишем куки-----
                setcookie('id', $reg_arr['id'], time() + 3600 * 24 * 30, '/');
                setcookie('p', $reg_arr['pas'], time() + 3600 * 24 * 30, '/');
                //--------------
                $this->loc(H . '/login/success');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
        }

        $this->des->set('email_confirm', true);
        $this->des->display('login');
    }

    public function index() {

        if ($this->user['id']) {
            $this->error('Вы уже авторизированы!');
        }

        //Авторизация через логин-пароль---
        if (isset($_POST['login'])) {
            //Закрываем авторизацию по логину-паролю
            $this->error('Авторизация возможна только через Steam');
            
            
            $this->des->set('title', 'Авторизация');

            try {
                if ($arr = SiteRead::me()->auth($_POST['login'], $_POST['pas'])) {
                    //Авторизируем пользователя
                    $_SESSION['user_id'] = $arr['id'];
                    //Пишем куки-----
                    if (isset($_POST['remember'])) {
                        setcookie('id', $arr['id'], time() + 3600 * 24 * 30, '/');
                        setcookie('p', $arr['pas'], time() + 3600 * 24 * 30, '/');
                    }
                    //--------------              
                    $this->loc($this->back_url);
                }
            } catch (Exception $e) {
                $this->error($e->getMessage(), false);
            }
        }
        //--------------
        //Авторизация через OpenID
        $openid = new LightOpenID(H);
        if (!$openid->mode) {
            $openid->identity = 'http://steamcommunity.com/openid';
            $this->loc($openid->authUrl());
        } elseif ($openid->mode == 'cancel') {
            echo 'Авторизация отменена';
        } else {
            if (!$openid->validate()) {
                $this->error('Ошибка авторизации');
            }
            $id = $openid->identity;
            $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);

            $_SESSION['steamid'] = $matches[1];
            $_SESSION['steam'] = Dota::me()->get_user_profile($_SESSION['steamid']);
            $_SESSION['user_id'] = SiteWrite::me()->steamRegistrationUser($_SESSION['steamid'], $_SESSION['steam']['personaname']);
            $this->loc(H);
        }


        //$this->des->display('login');
        $this->des->display('_auth_form_steam');
    }

    //Выход -----------------
    function logout() {
        $_SESSION['user_id'] = 0;
        $_SESSION['steamid'] = 0;
        $_SESSION['steam'] = 0;
        unset($_SESSION);
        setcookie('id', '', 0, '/');
        setcookie('p', '', 0, '/');
        $this->loc($this->back_url);
    }

    //----------------------
    //Восстановление пароля-
    function forget() {
        $captcha = new Captcha();
        $this->des->set('captcha', $captcha);
        $this->des->set('title', 'Восстановление пароля');
        $this->des->set('forget', true);

        //Обработка формы---
        if (!empty($_POST['emlogin'])) {
            if (!$captcha->is_access($_POST['captcha'])) {
                $this->error('Не верно введены символы с картинки');
            }

            $res = $this->db->prepare("SELECT email,login FROM users WHERE login=? OR email=?;");
            $res->execute(Array($_POST['emlogin'], $_POST['emlogin']));
            if (!$row = $res->fetch()) {
                if (Func::valid_email($_POST['emlogin'])) {
                    $this->error('Пользователь с таким Email не зарегистрирован', false);
                } else {
                    $this->error('Пользователь с таким логином не зарегистрирован', false);
                }
            } elseif (!$row['email']) {
                $this->error('У пользователя ' . $row['login'] . ' не заполнен Email. Смена пароля не возможна.', false);
            } else {
                $res = $this->db->prepare("SELECT login FROM tmp_users WHERE login=?;");
                $res->execute(Array($row['login']));
                if ($arr = $res->fetch()) {
                    $this->error('Инструкция для смены пароля уже выслана вам на Email. Повторить попытку вы сможете через 24 часа.');
                }

                $code = Func::rand_string(20);
                $this->db->query("DELETE FROM tmp_users WHERE time<UNIX_TIMESTAMP()-3600*24;");
                $res = $this->db->prepare("INSERT INTO tmp_users (login,code,time) VALUES (?,?,UNIX_TIMESTAMP());");
                $res->execute(Array($row['login'], $code));
                //Высылаем инструкцию по смене пароля
                $from_name = 'Администрация ' . $_SERVER['HTTP_HOST'];
                $from_email = 'admin@' . $_SERVER['HTTP_HOST'];
                $mail_subject = 'Смена пароля';
                $mail_text = $row['login'] . ', для смены пароля на сайте ' . H . ' перейдите по следующей ссылке:' . "\n" . H . '/login/change_pass/' . $code;
                Func::send_mail($from_name, $from_email, $row['login'], $row['email'], $mail_subject, $mail_text);

                $this->des->set('forget_email', true);
            }
        }
        //------------------

        $this->des->display('login');
    }

    //----------------------

    function change_pass() {
        $this->des->set('change_pass', true);
        $this->des->set('title', 'Смена пароля');

        if (!isset($this->args[0])) {
            $this->error('Не верная ссылка');
        }
        $this->db->query("DELETE FROM tmp_users WHERE time<UNIX_TIMESTAMP()-3600*24;");
        $res = $this->db->prepare("SELECT login FROM tmp_users WHERE code=?;");
        $res->execute(Array($this->args[0]));
        if (!$info = $res->fetch()) {
            $this->error('Не верная ссылка. Возможно она устарела. Пройдите <a href="' . H . '/login/forget">процедуру восстановления</a> ещё раз.');
        }

        //Смена пароля----
        if (isset($_POST['pas']) AND isset($_POST['repas'])) {
            if ($_POST['pas'] <> $_POST['repas']) {
                $this->error('Пароли не совпадают', false);
            } elseif (mb_strlen($_POST['pas'], 'utf-8') < 5) {
                $this->error('Длина пароля должна быть не менее 5и символов.', false);
            } else {
                //Всё ок--
                $md5pas = md5('cms' . md5($_POST['pas']));
                $res = $this->db->prepare("UPDATE users SET pas=? WHERE login=?;");
                $res->execute(Array($md5pas, $info['login']));
                $res = $this->db->prepare("DELETE FROM tmp_users WHERE code=?;");
                $res->execute(Array($this->args[0]));
                $this->des->set('change_pass_success', true);
            }
        }
        //----------------

        $this->des->set('user', $info);
        $this->des->display('login');
    }

}

?>
