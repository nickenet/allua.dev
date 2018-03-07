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

include ( "./defaults.php" );
$titlestat="Статистика каталога";

$incomingline = "<a href=\"index.php\">
                       <font color=\"$def_status_font_color\">
                        <u>$def_catalogue</u>
                       </font>
                      </a> | <font color=\"$def_status_font_color\">$titlestat</font>";
$incomingline_firm=$titlerating;

$help_section = $statistica_help;

include ( "./template/$def_template/header.php" );


main_table_top  ($titlestat);

// Counting listings, and gathering statistics

If ($def_int_dle=="YES") {

$rstat1=$db->query ("select COUNT(*) from $db_users where firmname!=''") or die ("mySQL error!");

$rstat2=$db->query ("select COUNT(*) from $db_users where firmstate='on'") or die ("mySQL error!");

$rstat3=$db->query ("select COUNT(*) from $db_users where firmstate='off' and firmname!=''") or die ("mySQL error!");

} else

{

$rstat1=$db->query ("select COUNT(*) from $db_users") or die ("mySQL error!");

$rstat2=$db->query ("select COUNT(*) from $db_users where firmstate='on'") or die ("mySQL error!");

$rstat3=$db->query ("select COUNT(*) from $db_users where firmstate='off'") or die ("mySQL error!");

}

$rstat4=$db->query ("select COUNT(*) from $db_users where flag='A'") or die ("mySQL error!");

$rstat5=$db->query ("select COUNT(*) from $db_users where flag='B'") or die ("mySQL error!");

$rstat6=$db->query ("select COUNT(*) from $db_users where flag='C'") or die ("mySQL error!");

$rstat7=$db->query ("select COUNT(*) from $db_users where flag='D'") or die ("mySQL error!");

$rstat8=$db->query ("select COUNT(*) from $db_offers") or die ("mySQL error!");

$rstat9=$db->query ("select COUNT(*) from $db_offers where type='1'") or die ("mySQL error!");

$rstat10=$db->query ("select COUNT(*) from $db_offers where type='2'") or die ("mySQL error!");

$rstat11=$db->query ("select COUNT(*) from $db_offers where type='3'") or die ("mySQL error!");

$rstat12=$db->query ("select COUNT(*) from $db_category") or die ("mySQL error!");
      
$rstat13=$db->query ("select COUNT(*) from $db_subcategory") or die ("mySQL error!");
       
$rstat14=$db->query ("select COUNT(*) from $db_subsubcategory") or die ("mySQL error!");

$rstat15=$db->query ("select COUNT(*) from $db_location") or die ("mySQL error!");

$rstat16=$db->query ("select COUNT(*) from $db_states") or die ("mySQL error!");

$rstat17=$db->query ("select COUNT(*) from $db_reviews where status='on'") or die ("mySQL error!");

$rstat18=$db->query ("select COUNT(*) from $db_reviews where status='off'") or die ("mySQL error!");

$rstat19=$db->query ("select COUNT(*) from $db_exelp") or die ("mySQL error!");

$rstat20=$db->query ("select COUNT(*) from $db_video") or die ("mySQL error!");

$rstat21=$db->query ("select COUNT(*) from $db_info where type='1'") or die ("mySQL error!");

$rstat22=$db->query ("select COUNT(*) from $db_info where type='2'") or die ("mySQL error!");

$rstat23=$db->query ("select COUNT(*) from $db_info where type='3'") or die ("mySQL error!");

$rstat24=$db->query ("select COUNT(*) from $db_info where type='4'") or die ("mySQL error!");

$rstat25=$db->query ("select COUNT(*) from $db_info where type='5'") or die ("mySQL error!");

	$result = $db->query ('SELECT VERSION() AS version');
	if ($result != FALSE && @mysql_num_rows($result) > 0) {
	$row   = $db->fetcharray ($result);
	$match = explode('.', $row['version']);


$banhandle = opendir('./banner');

$bancount=0;

while (false != ($banfile = readdir($banhandle))) {
	if ($banfile != "." && $banfile != ".." && $banfile != "_vti_cnf" && $banfile != "index.html" && $banfile != ".htaccess") {
		$bancount++;
	}
}
closedir($banhandle);



$banhandle2 = opendir('./banner2');

$bancount2=0;

while (false != ($banfile2 = readdir($banhandle2))) {
	if ($banfile2 != "." && $banfile2 != ".." && $banfile2 != "_vti_cnf" && $banfile2 != "index.html" && $banfile2 != ".htaccess") {
		$bancount2++;
	}
}
closedir($banhandle2);



$logohandle = opendir('./logo');

$logocount=0;

while (false != ($logofile = readdir($logohandle))) {
	if ($logofile != "." && $logofile != ".." && $logofile != "_vti_cnf" && $logofile != "index.html" && $logofile != ".htaccess" && $logofile != "nologo.gif") {	
$logocount++;
	}
}
closedir($logohandle);

$logohandle2 = opendir('./gallery');

$logocount2=0;

while (false != ($logofile2 = readdir($logohandle2))) {
	if ($logofile2 != "." && $logofile2 != ".." && $logofile2 != "_vti_cnf" && $logofile2 != "index.html" && $logofile2 != ".htaccess") {
		$logocount2++;
	}
}
closedir($logohandle2);


?>
<br>
<table cellspacing=1 cellpadding=5 border=0 width=98%>
	<tr><td valign=center align=center colspan=2>
	 <font face=verdana color=red><b><? echo "Сгенерирована: ".date("H:i:s"); ?></b></font>
	</td></tr>
	<tr>

	 <td valign=top align=left  width=50%>
	  <br>

<?php	

}

?>

Всего компаний: <b><?php echo mysql_result($rstat1, 0 ,0); ?></b><br><br>
Одобрено: <b><?php echo mysql_result($rstat2, 0 ,0); ?></b><br>
Ожидающих проверки: <b><?php echo mysql_result($rstat3, 0 ,0); ?></b><br>

<br>

Всего комментариев: <b><?php echo mysql_result($rstat17, 0 ,0); ?></b><br>

Комментарии ожидающие проверки: <b><?php echo mysql_result($rstat18, 0 ,0); ?></b><br>

<br>

<?php 

if ($def_allow_products == "YES")

{

echo "Продукции и услуг: "; ?><b><?php echo mysql_result($rstat8, 0 ,0); ?></b> <br><br>

<?php echo "$def_offer_1"; ?>: <b><?php echo mysql_result($rstat9, 0 ,0); ?></b> <br>
<?php echo "$def_offer_2"; ?>: <b><?php echo mysql_result($rstat10, 0 ,0); ?></b> <br>
<?php echo "$def_offer_3"; ?>: <b><?php echo mysql_result($rstat11, 0 ,0); ?></b> <br>
<br><br>
<b>Размещено в тарифных планах:</b><br>

<?php 

}


if ($def_A_enable == "YES" ) { echo "$def_A"; ?>: <b><?php echo mysql_result($rstat4, 0 ,0); ?></b> <br> <?php } ?>
<?php if ($def_B_enable == "YES" ) { echo "$def_B"; ?>: <b><?php echo mysql_result($rstat5, 0 ,0); ?></b> <br> <?php } ?>
<?php if ($def_C_enable == "YES" ) { echo "$def_C"; ?>: <b><?php echo mysql_result($rstat6, 0 ,0); ?></b> <br> <?php } ?>
<?php echo "$def_D"; ?>: <b><?php echo mysql_result($rstat7, 0 ,0); ?></b> <br>

<br>

</td>
<td valign=top align=left width=50%>

<br>

<?php echo "Категорий"; ?>: <b><?php echo mysql_result($rstat12, 0 ,0); ?></b><br>
<?php echo "Подкатегорий"; ?>: <b><?php echo mysql_result($rstat13, 0 ,0); ?></b><br>
<?php echo "Разделов подкатегорий"; ?>: <b><?php echo mysql_result($rstat14, 0 ,0); ?></b><br><br>
<?php echo "Стран"; ?>: <b><?php echo mysql_result($rstat15, 0 ,0); ?></b><br>
<?php if ($def_states_allow == "YES") { echo "Областей"; ?>: <b><?php echo mysql_result($rstat16, 0 ,0); ?></b><br> <?php } ?>

<br>

<?php echo "Логотипов"; ?>: <b><?php echo "$logocount"; ?></b><br>
<?php echo "Баннеров TOP"; ?>: <b><?php echo "$bancount"; ?></b><br>
<?php echo "Баннеров SIDE"; ?>: <b><?php echo "$bancount2"; ?></b><br>
<?php echo "Изображений"; ?>: <b><?php echo $logocount2/2; ?></b><br>
<?php echo "Excel прайсов"; ?>: <b><?php echo mysql_result($rstat19, 0 ,0); ?></b><br>
<?php echo "Видеороликов"; ?>: <b><?php echo mysql_result($rstat20, 0 ,0); ?></b><br>
<?php echo "Новостей компаний"; ?>: <b><?php echo mysql_result($rstat21, 0 ,0); ?></b><br>
<?php echo "Тендеров"; ?>: <b><?php echo mysql_result($rstat22, 0 ,0); ?></b><br>
<?php echo "Объявлений"; ?>: <b><?php echo mysql_result($rstat23, 0 ,0); ?></b><br>
<?php echo "Вакансий"; ?>: <b><?php echo mysql_result($rstat24, 0 ,0); ?></b><br>
<?php echo "Пресс-релизов"; ?>: <b><?php echo mysql_result($rstat25, 0 ,0); ?></b><br>


<br>

</td></tr>
</table>
<br><br>
<?php

require_once 'includes/zsearch.php';

$requests = new zSearch;

#Показать записи
echo "<noindex><div align=\"left\"><b>Последние $def_zsearch_num поисковых запросов по компаниям:</b><br>";
echo $requests->get($def_zsearch_num);
echo "</div></noindex>";

 main_table_bottom();

 include ( "./template/$def_template/footer.php" );

 ?>