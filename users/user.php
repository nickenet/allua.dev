<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi
  =====================================================
  Файл: logo.php
  -----------------------------------------------------
  Назначение: Основной управляющий файл
  =====================================================
 */

define('ISB', true);

@ $randomized = rand(999, 99999999999);

require_once ( 'defaults_users.php' );

session_start();

if ((!isset($_SESSION['login']) ) or (!isset($_SESSION['pass']) ) or (!isset($_SESSION['ident']) ) or (!isset($_SESSION['auth']) ))
{

	$_SESSION['login'] = mysql_real_escape_string(Trim($_POST['login']));
	$_SESSION['pass'] = my_crypt(mysql_real_escape_string($_POST['pass']));
	$_SESSION['ident'] = time();
	$_SESSION['count'] = 0;


	$ip = $_SERVER["REMOTE_ADDR"];

	$_SESSION['auth'].= $ip;

	mt_srand(make_seed());
	$nonce = mt_rand(1, 10000000); #генерируем слуайное число 
	$nonce = md5($nonce); #превращаем это число в случайную строку 
	$_SESSION['nonce'] = $nonce; #запоминаем наш случайный ключ к следуйщей странице
}


if ((!isset($_SESSION['nonce']) || strlen($_SESSION['nonce']) != 32))
	die("Hacking attempt!");

if (isset($_GET['code'])) {

    $id_firm=intval($_GET['id']);
    $code_firm=intval($_GET['code']);
    $r_code = $db->query("SELECT tmail FROM $db_users WHERE selector='$id_firm' LIMIT 1");
    $f_code = $db->fetcharray($r_code);

    if ($f_code['tmail']==$code_firm) {        

        $db->query("UPDATE $db_users SET tmail='1' WHERE selector='$id_firm' LIMIT 1");
        $error_auth = 4;
        require('template/auth.php');
        exit;

    } else {

        $error_auth = 5;
        require('template/auth.php');
        exit;

    }
}

If ((isset($_POST[security])) and ($_POST[security] != "$_SESSION[random]"))
{
	$error_auth = 3;
	require('template/auth.php');
	exit;
}


if ($_GET["REQ"] == "authorize")
{

	$r = $db->query("SELECT * FROM $db_users WHERE login='$_SESSION[login]' LIMIT 1");

	$f = $db->fetcharray($r);
        
	if (check_loginup($f["selector"], $f["login"], $f["pass"], mysql_num_rows($r), $_SESSION["login"], $_SESSION['pass'], $_POST['pass']))
	{

		if (( $f["firmstate"] == "off" ) and ($def_int_dle != "YES")) $_GET["mod"]="first";
 
                    require 'inc/ajax.php';

			$def_title_user = "Личный кабинет клиента";

			require_once ('template/header.php');

			$f_firma = $f[selector];
			$f_flag = $f[flag];

			if (isset($_GET['konstruktor'])) require_once ('konstruktor.php');
                            elseif (isset($_GET['apx'])) require_once ('apx.php');
                        
                        else {
				switch ($_GET["mod"])
				{

					case "moduser":
						require('modules/info.php');
						$mLogi = "Просмотр информации";
						break;

					case "changeinfo":
						require('modules/change_info.php');
						$mLogi = "Изменение информации";
						break;

					case "logo":
						require('modules/logo.php');
						$mLogi = "Логотип компании";
						break;

					case "sxema":
						require('modules/sxema.php');
						$mLogi = "Схема проезда";
						break;

					case "map":
						require('modules/map.php');
						$mLogi = "Положение на карте";
						break;

					case "filial":
						require('modules/edfilial.php');
						$mLogi = "Филиалы компаний";
						break;

					case "banner":
						require('modules/banner.php');
						$mLogi = "Баннеры";
						break;

					case "banner2":
						require('modules/banner.php');
						$mLogi = "Баннеры";
						break;

					case "edgallery":
						require('modules/edgallery.php');
						$mLogi = "Галерея изображений";
						break;

					case "edoffers":
						require('modules/edoffers.php');
						$mLogi = "Продукция и услуги";
						break;

					case "edexcel":
						require('modules/edexcel.php');
						$mLogi = "Excel прайсы";
						break;

					case "edvideo":
						require('modules/edvideo.php');
						$mLogi = "Видеоролик";
						break;

					case "info":
						require('modules/cominfo.php');
						$mLogi = "Информационный блок";
						break;

					case "reviews":
						require('modules/reviews.php');
						$mLogi = "Работа с комментариями";
						break;

					case "tarif":
						require('modules/tarif.php');
						$mLogi = "Смена тарифного плана";
						break;

					case "config":
						require('modules/config.php');
						$mLogi = "Настройки в каталоге";
						break;

					case "seo":
						require('modules/seo.php');
						$mLogi = "Имя страницы и SEO";
						break;

					case "case":
						require('modules/case.php');
						$mLogi = "Документы компании";
						break;

					case "theme":
						require('modules/theme.php');
						$mLogi = "Темы оформления";
						break;

					case "kodrating":
						require('modules/kodrating.php');
						break;

					case "topay":
						require('modules/topay.php');
						$mLogi = "Заявка на перевод в платную группу";
						break;

					case "card":
						require('modules/card.php');
						$mLogi = "Визитная карточка";
						break;

					case "support":
						require('modules/support.php');
						$mLogi = "Отправка письма в службу поддержки";
						break;

					case "uslugi":
						require('modules/uslugi.php');
						$mLogi = "Дополнительные услуги каталога";
						break;

					case "stat":
						require('modules/stat.php');
						$mLogi = "Работа со статистикой";
						break;

					case "printcard":
						require('template/card_print.php');
						$mLogi = "Печать визитной карточки";
						break;
                                            
					case "first":
						require('modules/first.php');
						$mLogi = "Первый вход в кабинет";
						break;

					default: require('modules/main.php');
				}
			}

			// Логи

			if (($def_logi_file == "YES") and (isset($mLogi)))
			{

				logi($f_firma, $f_flag, $mLogi);

				$date_log = date("YmdH");

				if ($f[date_mod] != $date_log)
					$db->query("UPDATE $db_users SET date_mod=$date_log WHERE selector='$f[selector]'");
			}

			require_once ('template/footer.php');
	}

	else
	{

		$error_auth = 1;
		$_SESSION['count'] = $_SESSION['count'] + 1;
		require('template/auth.php');
	}
}
else
{

	require('template/auth.php');
}
?>