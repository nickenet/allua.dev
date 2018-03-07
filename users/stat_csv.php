<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: stat_csv.php
-----------------------------------------------------
 Назначение: Формирование CSV файлов
=====================================================
*/

$id=intval($_POST[cid]);

if ($id==0) {
	die( "Hacking attempt!" );
}

$file_csv=$_POST[file_csv];

require_once ( 'defaults_users.php' );

        $r = $db->query  ( "SELECT * FROM $db_users WHERE selector='$id'" );

	$f = $db->fetcharray  ( $r );

	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
		$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	} else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
		$HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	} else if (!isset($HTTP_USER_AGENT)) {
		$HTTP_USER_AGENT = '';
	}


	// 1. Platform
	if (strstr($HTTP_USER_AGENT, 'Win')) {
		define('PMA_USR_OS', 'Win');
	} else if (strstr($HTTP_USER_AGENT, 'Mac')) {
		define('PMA_USR_OS', 'Mac');
	} else if (strstr($HTTP_USER_AGENT, 'Linux')) {
		define('PMA_USR_OS', 'Linux');
	} else if (strstr($HTTP_USER_AGENT, 'Unix')) {
		define('PMA_USR_OS', 'Unix');
	} else if (strstr($HTTP_USER_AGENT, 'OS/2')) {
		define('PMA_USR_OS', 'OS/2');
	} else {
		define('PMA_USR_OS', 'Other');
	}



	// 2. browser and version
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

	if ( preg_match('#Opera(/| )([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[2]);
	  define('PMA_USR_BROWSER_AGENT', 'OPERA');
	} 
	elseif ( preg_match('#MSIE ([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'IE');
	} 
	elseif ( preg_match('#OmniWeb/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
	} 
	elseif ( preg_match('#Mozilla/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'MOZILLA');
	} 
	elseif ( preg_match('#Konqueror/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
	} 
	else 
	{
	  define('PMA_USR_BROWSER_VER', 0);
	  define('PMA_USR_BROWSER_AGENT', 'OTHER');
	}


	// Send headers
	header('Content-Type: application/octetstream');

	if (PMA_USR_BROWSER_AGENT == 'IE') {
		header('Content-Disposition: inline; filename="' . $file_csv . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="' . $file_csv . '"');
		header('Expires: 0');
		header('Pragma: no-cache');
	}

$data_reg=undate($f[date], $def_datetype);

$catzzz=explode(":", $f[category]);

for ($zzz=0;$zzz<count($catzzz);$zzz++)

{

$catzzz1 = explode ("#", $catzzz[$zzz]);

     $res2 = $db->query ( "SELECT * FROM $db_category WHERE selector='$catzzz1[0]'");
     $fe2 = $db->fetcharray ( $res2 );

if ($db->numrows($res2) > 0)
{
    $caturl = "category=$catzzz1[0]";
    $showcategory2 = "$fe2[category]";
}
else
     $showcategory2 = "";

     $db->freeresult ( $res2 );

     $res = $db->query ( "SELECT * FROM $db_subcategory WHERE catsubsel='$catzzz1[1]'");
     $fe = $db->fetcharray ( $res );
if ($db->numrows($res) > 0)
{
$caturl = "cat=$catzzz1[0]&subcat=$catzzz1[1]";
$showcategory = " / $fe[subcategory]";
}
else
{
     $showcategory = "";
}
     $db->freeresult ( $res );

     $res3 = $db->query ( "SELECT * FROM $db_subsubcategory WHERE catsel='$catzzz1[0]' and catsubsel='$catzzz1[1]' and catsubsubsel='$catzzz1[2]'");
     $fe3 = $db->fetcharray ( $res3 );
if ($db->numrows($res3) > 0)
{
     $caturl .= "&subsubcat=$catzzz1[2]";
     $showsubcategory = " / $fe3[subsubcategory]";
}
else
     $showsubcategory = "";

     $db->freeresult ( $res3 );

$dev_out.= "$showcategory2 $showcategory $showsubcategory";

}

// Пишем в файл

echo "Дата регистрации в каталаге;$data_reg;\r\n";
echo "Регистрация в категориях;$dev_out;\r\n";
echo "Просмотров;$f[counter];\r\n";
echo "Посетителей сайта;$f[webcounter];\r\n";
echo "Полученные сообщения;$f[mailcounter];\r\n";
echo "Филиалы;$f[filial];\r\n";


if (( $f["info"] > 0 ) and ($def_allow_info == "YES"))

		{

echo "$def_info_dop;$f[info];\r\n";
echo "$def_info_news;$f[news];\r\n";
echo "$def_info_tender;$f[tender];\r\n";
echo "$def_info_board;$f[board];\r\n";
echo "$def_info_job;$f[job];\r\n";
echo "$def_info_pressrel;$f[pressrel];\r\n";

		}


if (( $f["prices"] > 0 ) and ($def_allow_products == "YES"))

		{

			$r = mysql_query ( "SELECT * FROM $db_offers WHERE firmselector='$f[selector]'" );
			@$results_amount_offers = mysql_num_rows ( $r );

echo "Загружено продукции и услуг;$results_amount_offers;\r\n";
echo "Просмотров продукции и услуг;$f[price_show];\r\n";
		}


if (( $f["images"] > 0 ) and ($def_allow_images == "YES"))

		{

			$rc = mysql_query ( "SELECT * FROM $db_images WHERE firmselector='$f[selector]'" );
			@$results_amount_images = mysql_num_rows ( $rc );

echo "Загружено изображений в галерею;$results_amount_images;\r\n";
		}

if (( $f["exel"] > 0 ) and ($def_allow_exel == "YES"))

		{

			$rc = mysql_query ( "SELECT * FROM $db_exelp WHERE firmselector='$id'" );
			@$results_amount_exel = mysql_num_rows ( $rc );

echo "Загружено Excel прайсов;$results_amount_exel;\r\n";
		}

if (( $f["video"] > 0 ) and ($def_allow_video == "YES"))

		{

			$rcv = mysql_query ( "SELECT * FROM $db_video WHERE firmselector='$id'" );
			@$results_amount_video = mysql_num_rows ( $rcv );

echo "Видеоролики;$results_amount_video;\r\n";
		}

if ($def_banner_allowed == "YES") {

	if ( (($f[flag] == "D") and ($def_D_banner == "YES")) or (($f[flag] == "C") and ($def_C_banner == "YES")) or (($f[flag] == "B") and ($def_B_banner == "YES")) or (($f[flag] == "A") and ($def_A_banner == "YES")) )

	{

		@ $bannerctr=$f["banner_click"]*100/$f["banner_show"];
		@ $bannerctr=round($bannerctr,2);
echo "Показы баннеров;$f[banner_show];\r\n";
echo "Кликов по баннеру;$f[banner_click];\r\n";
echo "CTR (%) баннера;$bannerctr%;\r\n";

	}
}

if ($def_reviews_enable == "YES")

{
	$rev=$db->query ("SELECT * from $db_reviews where company = '$f[selector]'") or die (mysql_error());
	$reviews=mysql_num_rows($rev);

echo "Комментарии;$reviews;\r\n";

}

if ($def_rating_allowed == "YES") {

	unset($rating_listing);

	if (($def_rating_allowed == "YES") and ($f[countrating] > 0) and ($f[votes] > 0)) {
		$rating_listing="";
		for ($rate=0;$rate<$f[countrating];$rate++) {
			$rating_listing.="*";
		}

		$rating_listing.=" ($f[votes] $def_votes)";

echo "Оценка посетителей;$rating_listing;\r\n";


		}
}

?>