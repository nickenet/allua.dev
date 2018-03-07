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
 Назначение: Статистика каталога
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$stat_catalog_help;

function view_find_last_content()

{

	global $def_offers;
	global $def_images;
	global $def_exelp;
	global $def_admin_video;
	global $def_info_news;
	global $def_info_tender;
	global $def_info_board;
	global $def_info_job;
	global $def_info_pressrel;

echo '<br />';

table_fdata_top ('Показать последний контент');

?>

<form name=upview action="?REQ=stat" method=post>
<table width="700" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">Укажите раздел&nbsp;
      <select name="content">
        <option value="1" selected><? echo $def_offers; ?></option>
        <option value="2"><? echo $def_images; ?></option>
        <option value="3"><? echo $def_exelp; ?></option>
        <option value="4"><? echo $def_admin_video; ?></option>
        <option value="5"><? echo $def_info_news; ?></option>
        <option value="6"><? echo $def_info_tender; ?></option>
        <option value="7"><? echo $def_info_board; ?></option>
        <option value="8"><? echo $def_info_job; ?></option>
        <option value="9"><? echo $def_info_pressrel; ?></option>
      </select>
      &nbsp;
показать последние&nbsp;
<select name="colvo">
  <option value="5" selected>5</option>
  <option value="10">10</option>
  <option value="20">20</option>
  <option value="50">50</option>
</select>
&nbsp;
<input name="button" type="submit" id="button" value="Показать" /></td>
  </tr>
</table></form><br />

<?

table_fdata_bottom();

}


$title_cp = 'Статистика каталога - ';
$speedbar = ' | <a href="stat.php">Статистика</a>';

check_login_cp('5_1','stat.php');

require_once 'inc/cron.php';

require_once 'template/header.php';

table_item_top ($def_item_stat_data,'stats.png');

if (!$_GET[REQ]) { require_once 'inc/stat.php';

view_find_last_content();

} else

{

$type_content=intval($_POST[content]);
$colvo=intval($_POST[colvo]);

switch ($type_content) {

		case 1:
			 $sql_sel = "SELECT * FROM $db_offers ORDER BY date DESC";
			 $type_vid = $def_offers;
			 $link_edit = "edoffers.php?id=";
			 break;

		case 2:
			 $sql_sel = "SELECT * FROM $db_images ORDER BY date DESC";
			 $type_vid = $def_images;
			 $link_edit = "edgallery.php?id=";
			 break;

		case 3:
			 $sql_sel = "SELECT * FROM $db_exelp ORDER BY date DESC";
			 $type_vid = $def_exelp;
			 $link_edit = "edexel.php?id=";
			 break;

		case 4:
			 $sql_sel = "SELECT * FROM $db_video ORDER BY date DESC";
			 $type_vid = $def_admin_video;
			 $link_edit = "edvideo.php?id=";
			 break;

		case 5:
			 $sql_sel = "SELECT * FROM $db_info WHERE type='1' ORDER BY date DESC, datetime DESC";
			 $type_vid = $def_info_news;
			 $link_edit = "edinfo.php?id=";
			 break;

		case 6:
			 $sql_sel = "SELECT * FROM $db_info WHERE type='2' ORDER BY date DESC, datetime DESC";
			 $type_vid = $def_info_tender;
			 $link_edit = "edinfo.php?id=";
			 break;

		case 7:
			 $sql_sel = "SELECT * FROM $db_info WHERE type='3' ORDER BY date DESC, datetime DESC";
			 $type_vid = $def_info_board;
			 $link_edit = "edinfo.php?id=";
			 break;

		case 8:
			 $sql_sel = "SELECT * FROM $db_info WHERE type='4' ORDER BY date DESC, datetime DESC";
			 $type_vid = $def_info_job;
			 $link_edit = "edinfo.php?id=";
			 break;

		case 9:
			 $sql_sel = "SELECT * FROM $db_info WHERE type='5' ORDER BY date DESC, datetime DESC";
			 $type_vid = $def_info_pressrel;
			 $link_edit = "edinfo.php?id=";
			 break;

			}

$rz = $db->query ( "$sql_sel LIMIT $colvo" );
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 )

{

echo '<br />';

table_fdata_top ('Контент - '.$type_vid.' ['.$colvo.']');

echo '<table width="900" border="0" cellspacing="2" cellpadding="2">';

	for ($i=0; $i<$results_amount; $i++ ) {

	$fz = $db->fetcharray  ( $rz );

	echo "<tr><td width=\"80\" align=\"right\"><b>$fz[date]</b></td><td align=\"left\" class=\"vclass\"><a href=\"$link_edit$fz[firmselector]\" target=\"_blank\">$fz[item]</a></td></tr>";
	
	}

echo '</table>';

table_fdata_bottom();

} else  msg_text('80%',$def_admin_message_error, 'Контент добавлен не был.');

view_find_last_content();

}

require_once 'template/footer.php';
		
?>