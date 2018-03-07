<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: defaults.php
-----------------------------------------------------
 Назначение: Подключение файлов
=====================================================
*/

session_start();

ini_set ('error_reporting', E_ALL & ~E_NOTICE);

define ( 'ISB', true );

srand ((double) microtime() * 10000000);

if (!isset($_GET['page'])) $_GET['page'] = "0";
if ($_GET['page'] == "") $_GET['page'] = "0";

if (isset($_REQUEST['page'])) $kPage = intval($_GET['page']); else $kPage = 0;
if (isset($_REQUEST['category'])) $categorymains = intval($_GET['category']); 
if (isset($_REQUEST['cat'])) $cat = intval($_GET['cat']); 
if (isset($_REQUEST['subcat'])) $subcat = intval($_GET['subcat']); 
if (isset($_REQUEST['subsubcat'])) $subsubcat = intval($_GET['subsubcat']);
if (isset($_REQUEST['id'])) $id = intval($_GET['id']);


// Including configuration file
include ( "./conf/config.php" );
 $def_mainlocation_pda = $def_mainlocation.'/'.$def_pda;

// Including memberships
include ( "./conf/memberships.php" );

// Including functions
include ( "./includes/functions.php" );

if ($def_mainlocation == "http://www.domain.com/папка") goto_url('install/index.php');

// Including mysql class
include ( "./includes/$def_dbtype.php" );

// Connecting to the database
include ( "./connect.php" );

// Including functions
include ( "./includes/sqlfunctions.php" );

if ($def_one_template=="YES") {
// ничего не делаем
} else

{

$arr_template = array();
# создадим массив папок в каталоге template 
if ($dir = @opendir("./template")) {
while (($file = readdir($dir)) !== false) {
if ((is_dir("./template/".$file)==TRUE)&&($file!='.' && $file!='..')) $arr_template[$file] = $file; 
} 
closedir($dir);
}

if (!isset($_COOKIE['template']) && !isset($_SESSION['template']) && !isset($_POST['template'])) {
# Устанавливаем в куки и сессию значение по умолчанию, определённому в конфиге 
$_SESSION['template'] = $def_template; 
setcookie ("template",$def_template,time()+(60*60*24*30),"/");
}
elseif (isset($_POST['template'])) 
{

# Проверрим переменную $_POST['template'] на корректность
if (in_array (trim($_POST['template']), $arr_template)) {
$def_template = trim ($_POST['template']);
# поставим в куки и занесём в сессию 
setcookie ("template",$def_template,time()+(60*60*24*30),'/');
$_SESSION['template'] = $def_template;
}

} 
elseif (isset($_COOKIE['template']) or isset($_SESSION['template'])) 
{
# Если установлено значение в сессии или в куках 
$def_template = (isset($arr_template[$_COOKIE['template']])=== TRUE ? $arr_template[$_COOKIE['template']] : $arr_template[$_SESSION['template']]);

}
else {
# ничего не делаем. Оставим по умолчанию 
}}


if(  ( (!empty($HTTP_COOKIE_VARS["lang"])) and ($_POST["lang"] != "") )
or ( (empty($HTTP_COOKIE_VARS["lang"])) and ($_POST["lang"] != "") ) )
{
	setcookie ("lang","",time()+(60*60*24*30),"","");
	setcookie ("lang",$_POST["lang"],time()+(60*60*24*30),"","");
	$lang = $_POST[lang];
}

if ( (empty($HTTP_COOKIE_VARS["lang"])) and (!isset($_POST["lang"])) )
$lang = $def_language;

if ( (!empty($HTTP_COOKIE_VARS["lang"])) and (!isset($_POST["lang"])) )
$lang = $HTTP_COOKIE_VARS["lang"];


// Including template configuration file
include ( "./template/$def_template/settings.php" );

// Including language pack
include ( "./lang/language.$lang.php" );

$cookie_days = $def_notepad_days;

$cookie_time = time() + $cookie_days * 24 * 3600;

require_once 'includes/cache.php';

$cache = new Cache;

if ($def_logo_block=="YES") {

$handle_logo = opendir('./logo');

$count_logo=0;
while (false != ($file_logo = readdir($handle_logo))) {
	if ($file_logo != "." && $file_logo != "..") {
		$logo_block[$count_logo]="$file_logo";
		$count_logo++;
	}
}
closedir($handle_logo);

}

$meta_index='<meta name="robots" content="index,follow" />'."\n";

 // Укажите часовой пояс
 @date_default_timezone_set( 'Europe/Moscow' );

?>