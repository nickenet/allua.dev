<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: filial.php
-----------------------------------------------------
 Назначение: Филиалы
=====================================================
*/

include ( "./defaults.php" );

if (isset($_GET['print'])) {

$print_f=intval($_GET['print']);

	$re = $db->query  ( "SELECT * FROM $db_filial WHERE num = '$print_f'" );
	@$results_amount_2 = mysql_num_rows ( $re );

		if ( $results_amount_2 > 0 ) {

			include ("./includes/filialsub.php");
		} else

			{

			$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | $def_filial";

			include ( "./template/$def_template/header.php" );

			main_table_top($def_filial);

                            $def_message_error=$def_mailid_error;
                            include ( "./includes/error_page.php" );
                            
			main_table_bottom();

			include ( "./template/$def_template/footer.php" );

			}
				

} else {

$r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
$f_p = $db->fetcharray  ( $r );

if ($f_p[filial] > 0) { $results_amount = $f_p[filial]; $name_type="filial"; }

	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

	$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

	if ($cat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe["category"];
		$category = $fe[selector];

		if ($def_rewrite == "YES")
		$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= "<a href=\"index.php?category=$cat\">";

		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}

	if ($subcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showcategory = $fe["subcategory"];
		$subcategory = $fe[catsubsel];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

	if ($subsubcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showsubcategory = $fe["subsubcategory"];
		$subsubcategory = $fe[catsubsubsel];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$kPage\">";

		$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

// Формируем ЧПУ для компании

if (($category == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$category-0-0-$id-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$category-$subcategory-0-$id-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$category-$subcategory-$subsubcategory-$id-$kPage-0.html";

if ($def_rewrite == "YES")
$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> | $def_filial";
else
$incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> | $def_filial";

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;

$help_section = "$filial_help";

$incomingline_firm="$f_p[firmname] - $def_filial";

include ( "./template/$def_template/header.php" );

main_table_top($def_filial);


 if ($results_amount > 0)

 {
     $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id'" );

     include ("./includes/sub.php");

     $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
     require 'includes/components/stat.php'; // Подключаем файл статистики

	$re = $db->query  ( "SELECT * FROM $db_filial WHERE firmselector = '$id' ORDER BY cityf LIMIT $page1, $def_count_srch" );
	@$results_amount_2 = mysql_num_rows ( $re );

	include ("./includes/filialsub.php");

	// Страницы

	if ( $results_amount > $def_count_srch )

	{
		if ((($kPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kPage*$def_count_srch)-($def_count_srch*5);
		else $first=0;

		if ((($kPage*$def_count_srch)+($def_count_srch*6)) <= $results_amount) $last =($kPage*$def_count_srch)+($def_count_srch*6);
		else $last = $results_amount;

		@    $z=$first/$def_count_srch;

		if ($kPage > 0)

		{
			if ($def_rewrite == "YES") echo "<a href=\"$def_mainlocation/$name_type-$f_p[selector]-", $kPage-1 ,"-$category-$subcategory-$subsubcategory.html\"><b>$def_previous</b></a>&nbsp;";
			else echo "<a href=\"filial.php?id=$f_p[selector]&page=", $kPage-1 ,"&cat=$category&subcat=$subcategory&subsubcat=$subsubcategory\"><b>$def_previous</b></a>&nbsp;";
		}

		for ( $x=$first; $x<$last;$x=$x+$def_count_srch )

		{
			if ( $z == $kPage )

			{
				echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
				$z++;
			}

			else

			{
				if ($def_rewrite == "YES")

				echo "<a href=\"$def_mainlocation/$name_type-$f_p[selector]-$z-$category-$subcategory-$subsubcategory.html\"><b>", $z+1 ,"</b></a>&nbsp;";

				else
				echo "<a href=\"filial.php?id=$f_p[selector]&page=$z&cat=$category&subcat=$subcategory&subsubcat=$subsubcategory\"><b>", $z+1 ,"</b></a>&nbsp;";

				$z++;
			}
		}
	}

	if ($kPage - (($results_amount / $def_count_srch) - 1) < 0)

	{
		if ($def_rewrite == "YES") echo "<a href=\"$def_mainlocation/$name_type-$f_p[selector]-", $kPage+1 ,"-$category-$subcategory-$subsubcategory.html\"><b>$def_next</b></a>";
		else echo "<a href=\"filial.php?id=$f_p[selector]&page=", $kPage+1 ,"&cat=$category&subcat=$subcategory&subsubcat=$subsubcategory\"><b>$def_next</b></a>";
	}

	echo "<br> <br> ";
	
 }

 else include ( "./includes/error_page.php" );

main_table_bottom();

include ( "./template/$def_template/footer.php" );

}

?>