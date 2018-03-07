<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: log.php
-----------------------------------------------------
 Назначение: Просмотр истории
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$log_help;

$title_cp = 'Просмотр истории - ';
$speedbar = ' | <a href="log.php?REQ=auth">Просмотр истории</a>';

check_login_cp('0_0','log.php?REQ=auth');

require_once 'template/header.php';

table_item_top ($def_item_history_data,'edit_firm.png');

$pages=50;

if ($_GET["REQ"] == "clear") {

		$db->query ("delete from $db_log") or die ("mySQL error!");
		
		msg_text("80%",$def_admin_message_ok,"Логи успешно удалены из таблицы!");
}


if ($_GET["REQ"] == "auth") {

table_fdata_top ('Дата и время действий [пользователь, IP]');

		$r=$db->query ("select * from $db_log") or die ("mySQL error!");

		$results_amount=mysql_num_rows($r);

		$npage=$_GET["page"]+1;
		$ppage=$_GET["page"]-1;
		$page1=$_GET["page"]*$pages;
		$page2=$page1+$pages;

		$r=$db->query ( "select * from $db_log ORDER BY selector DESC LIMIT $page1, $page2") or die("mySQL error!");

		$fetchcounter=$pages;

		$f=$results_amount-$page1;

		if ($f < $pages) $fetchcounter=$results_amount-$page1;

		echo '<br /><div style="text-align: center">';

		for($i=0; $i<$fetchcounter; $i++)
		{ 

		$f=$db->fetcharray ($r);

		echo "$f[log]<br />";
		}

		echo '</div><br />';

		echo '<table align="center" cellpadding="0" cellspacing="0"><tr>';

		$z=0;

		if ($results_amount > $pages){
			for($x=0; $x<$results_amount; $x=$x+$pages)
			{
				if ($z == $_GET[page]) {echo "<td valign=\"top\" align=\"center\" class=\"vclass\"><b><a href=#>[ ",$x+1,"-",$x+$pages," ]</a></b>&nbsp;&nbsp;</td>";$z++;} else {echo "<td valign=\"top\" align=\"center\" class=\"vclass\"><a href=log.php?REQ=auth&amp;page=$z&amp;pages=$pages>[",$x+1,"-",$x+$pages,"]</a>&nbsp;&nbsp;</td>";$z++;}
			}
		}

		echo "<td valign=\"top\" align=\"center\"><form action=log.php?REQ=clear method=post>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value=\"Очистить историю\" style=\"color: #FFFFFF; background: #D55454;\" /></form></td>";
		echo '</tr></table><br />';

table_fdata_bottom();

}

require_once 'template/footer.php';	

?>
