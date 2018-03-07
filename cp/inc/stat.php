<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: stat.php
-----------------------------------------------------
 Назначение: Формирование статистики
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

function gdversion() {
	static $gd_version_number = null;
	if( $gd_version_number === null ) {
		ob_start();
		phpinfo( 8 );
		$module_info = ob_get_contents();
		ob_end_clean();
		if( preg_match( "/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches ) ) {
			$gdversion_h = $matches[1];
		} else {
			$gdversion_h = 0;
		}
	}
	return $gdversion_h;
}

function formatsize($file_size) {
	if( $file_size >= 1073741824 ) {
		$file_size = round( $file_size / 1073741824 * 100 ) / 100 . " Gb";
	} elseif( $file_size >= 1048576 ) {
		$file_size = round( $file_size / 1048576 * 100 ) / 100 . " Mb";
	} elseif( $file_size >= 1024 ) {
		$file_size = round( $file_size / 1024 * 100 ) / 100 . " Kb";
	} else {
		$file_size = $file_size . " b";
	}
	return $file_size;
}

If ($def_int_dle=="YES") {

$rstat1=$db->query ("select COUNT(*) from $db_users where firmname!=''");

$rstat2=$db->query ("select COUNT(*) from $db_users where firmstate='on'");

$rstat3=$db->query ("select COUNT(*) from $db_users where firmstate='off' and firmname!=''");

$rstat33=$db->query ("select COUNT(*) from $db_users where firmstate='off' and firmname=''");

} else

{

$rstat1=$db->query ("select COUNT(*) from $db_users");

$rstat2=$db->query ("select COUNT(*) from $db_users where firmstate='on'");

$rstat3=$db->query ("select COUNT(*) from $db_users where firmstate='off'");

}

$rstat4=$db->query ("select COUNT(*) from $db_users where flag='A'");

$rstat5=$db->query ("select COUNT(*) from $db_users where flag='B'");

$rstat6=$db->query ("select COUNT(*) from $db_users where flag='C'");

$rstat7=$db->query ("select COUNT(*) from $db_users where flag='D'");

$rstat8=$db->query ("select COUNT(*) from $db_offers");

$rstat9=$db->query ("select COUNT(*) from $db_offers where type='1'");

$rstat10=$db->query ("select COUNT(*) from $db_offers where type='2'");

$rstat11=$db->query ("select COUNT(*) from $db_offers where type='3'");

$rstat12=$db->query ("select COUNT(*) from $db_category");
      
$rstat13=$db->query ("select COUNT(*) from $db_subcategory");
       
$rstat14=$db->query ("select COUNT(*) from $db_subsubcategory");

$rstat15=$db->query ("select COUNT(*) from $db_location");

$rstat16=$db->query ("select COUNT(*) from $db_states");

$rstat17=$db->query ("select COUNT(*) from $db_reviews where status='on'");

$rstat18=$db->query ("select COUNT(*) from $db_reviews where status='off'");

$rstat19=$db->query ("select COUNT(*) from $db_exelp");

$rstat20=$db->query ("select COUNT(*) from $db_video");

$rstat21=$db->query ("select COUNT(*) from $db_info where type='1'");

$rstat22=$db->query ("select COUNT(*) from $db_info where type='2'");

$rstat23=$db->query ("select COUNT(*) from $db_info where type='3'");

$rstat24=$db->query ("select COUNT(*) from $db_info where type='4'");

$rstat25=$db->query ("select COUNT(*) from $db_info where type='5'");

$rstat26=$db->query ("select COUNT(*) from $db_news ");

$rstat27=$db->query ("select COUNT(*) from $db_newsrev where status='on'");

$rstat28=$db->query ("select COUNT(*) from $db_newsrev where status='off'");

$rstat29=$db->query ("select COUNT(*) from $db_case where status='1'");

	$result = $db->query ('SELECT VERSION() AS version');
	if ($result != FALSE && @mysql_num_rows($result) > 0) {
	$row   = $db->fetcharray ($result);
	$match = explode('.', $row['version']);


$banhandle = opendir('.././banner');

$bancount=0;

while (false != ($banfile = readdir($banhandle))) {
	if ($banfile != "." && $banfile != ".." && $banfile != "_vti_cnf" && $banfile != "index.html" && $banfile != ".htaccess") {
		$bancount++;
	}
}
closedir($banhandle);


$banhandle2 = opendir('.././banner2');

$bancount2=0;

while (false != ($banfile2 = readdir($banhandle2))) {
	if ($banfile2 != "." && $banfile2 != ".." && $banfile2 != "_vti_cnf" && $banfile2 != "index.html" && $banfile2 != ".htaccess") {
		$bancount2++;
	}
}
closedir($banhandle2);


$logohandle = opendir('.././logo');

$logocount=0;

while (false != ($logofile = readdir($logohandle))) {
	if ($logofile != "." && $logofile != ".." && $logofile != "_vti_cnf" && $logofile != "index.html" && $logofile != ".htaccess" && $logofile != "nologo.gif") {
		$logocount++;
	}
}
closedir($logohandle);


$logohandle2 = opendir('.././gallery');

$logocount2=0;

while (false != ($logofile2 = readdir($logohandle2))) {
	if ($logofile2 != "." && $logofile2 != ".." && $logofile2 != "_vti_cnf" && $logofile2 != "index.html" && $logofile2 != ".htaccess") {
		$logocount2++;
	}
}
closedir($logohandle2);

}

?>

<div style="text-align: center"><? echo "$def_admin_stat<br>Сгенерирована: ".date("H:i:s"); ?><br /><br /></div>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="350" id="table_files_b">Компании</td>
    <td width="350" id="table_files_bc">Контент</td>
    <td width="300" id="table_files_b">Ситема</td>
  </tr>
  <tr>
    <td width="350" id="table_files_i" valign="top">
<? echo "$def_admin_companies"; ?>: <b><? echo mysql_result($rstat1, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_approved_companies"; ?>: <b><? echo mysql_result($rstat2, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_notapproved_companies"; ?>: <b><? echo mysql_result($rstat3, 0 ,0); ?></b><? if (mysql_result($rstat3, 0 ,0)>0) echo "<img src=\"images/stop.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" />"; ?><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo $def_status_case_admin; ?>: <b><? echo mysql_result($rstat29, 0 ,0); ?></b><? if (mysql_result($rstat29, 0 ,0)>0) echo "<img src=\"images/stop.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" />"; ?>
<? if ($def_int_dle=="YES") { echo "<br />Пользователи"; ?>: <b><? echo mysql_result($rstat33, 0 ,0); ?></b><? } ?><br /><br />
Размещено в тарифных планах<br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? if ($def_A_enable == "YES" ) { echo "$def_A"; ?>: <b><? echo mysql_result($rstat4, 0 ,0); ?></b><br /> <? } ?>
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? if ($def_B_enable == "YES" ) { echo "$def_B"; ?>: <b><? echo mysql_result($rstat5, 0 ,0); ?></b><br /> <? } ?>
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? if ($def_C_enable == "YES" ) { echo "$def_C"; ?>: <b><? echo mysql_result($rstat6, 0 ,0); ?></b><br /> <? } ?>
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_D"; ?>: <b><? echo mysql_result($rstat7, 0 ,0); ?></b><br /><br />
<? if($_SESSION['warning_pay']=='YES') { ?>
<img src="images/stop.gif" width="16" height="16" align="absmiddle" />&nbsp;Заканчивается срок пребывания в платном тарифе:<br />
<? echo $_SESSION['end_pay_tariff'].'<br/><br />'; } ?>
Всего комментариев: <b><? echo mysql_result($rstat17, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" />Комментарии ожидающие проверки: <b><? echo mysql_result($rstat18, 0 ,0); ?></b><? if (mysql_result($rstat18, 0 ,0)>0) echo "<img src=\"images/stop.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" />"; ?><br /><br />
<? echo "$def_admin_locations"; ?>: <b><? echo mysql_result($rstat15, 0 ,0); ?></b><br />
<? if ($def_states_allow == "YES") { echo "$def_admin_states"; ?>: <b><? echo mysql_result($rstat16, 0 ,0); ?></b><br /> <? } ?>
<br /><? echo "$def_admin_categories"; ?>: <b><? echo mysql_result($rstat12, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_subcategories"; ?>: <b><? echo mysql_result($rstat13, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_subsubcategories"; ?>: <b><? echo mysql_result($rstat14, 0 ,0); ?></b><br><br />
    </td>
    <td width="350" id="table_files_i_c" valign="top">
Графические элементы:<br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_logos"; ?>: <b><? echo "$logocount"; ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_banners TOP"; ?>: <b><? echo "$bancount"; ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_banners SIDE"; ?>: <b><? echo "$bancount2"; ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_admin_images_pics"; ?>: <b><? echo $logocount2/2; ?></b><br /><br />
<? echo "$def_admin_offers"; ?>: <b><? echo mysql_result($rstat8, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_offer_1"; ?>: <b><? echo mysql_result($rstat9, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_offer_2"; ?>: <b><? echo mysql_result($rstat10, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "$def_offer_3"; ?>: <b><? echo mysql_result($rstat11, 0 ,0); ?></b><br /><br />
<? echo "Excel прайсов"; ?>: <b><? echo mysql_result($rstat19, 0 ,0); ?></b><br />
<? echo "Видеороликов"; ?>: <b><? echo mysql_result($rstat20, 0 ,0); ?></b><br /><br />
Информационный блок:<br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Новостей компаний"; ?>: <b><? echo mysql_result($rstat21, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Тендеров"; ?>: <b><? echo mysql_result($rstat22, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Объявлений"; ?>: <b><? echo mysql_result($rstat23, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Вакансий"; ?>: <b><? echo mysql_result($rstat24, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Пресс-релизов"; ?>: <b><? echo mysql_result($rstat25, 0 ,0); ?></b><br /><br />
Новостей: <b><? echo mysql_result($rstat26, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><? echo "Комментариев к новостям"; ?>: <b><? echo mysql_result($rstat27, 0 ,0); ?></b><br />
<img src="images/tree.gif" width="31" height="17" align="absmiddle" />Комментарии ожидающие проверки: <b><? echo mysql_result($rstat28, 0 ,0); ?></b><? if (mysql_result($rstat28, 0 ,0)>0) echo "<img src=\"images/stop.gif\" width=\"16\" height=\"16\" align=\"absmiddle\" />"; ?><br />
    </td>
    <td width="300" id="table_files_i" valign="top">
<? $os_version = @php_uname( "s" ) . " " . @php_uname( "r" );
$maxmemory = (@ini_get( 'memory_limit' ) != '') ? @ini_get( 'memory_limit' ) : "Неопределено";
$dfs = @disk_free_space( "." );
$freespace = formatsize( $dfs );
$maxupload = str_replace( array ('M', 'm' ), '', @ini_get( 'upload_max_filesize' ) );
$maxupload = formatsize( $maxupload * 1024 * 1024 ); ?>
Операционная система: <b><? echo "$os_version"; ?></b><br />
Версия PHP: <b><? echo phpversion(); ?></b><br />
Версия MySQL: <b><? echo "$row[version]"; ?></b><br />
Версия GD: <b><? echo gdversion(); ?></b><br />
Выделено оперативной памяти: <b><? echo "$maxmemory"; ?></b><br />
Размер свободного места на диске: <b><? echo "$freespace"; ?></b><br />
Максимальный размер загружаемого файла: <b><? echo "$maxupload"; ?></b><br />
    </td>
  </tr>
</table>