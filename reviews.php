<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: reviews.php
-----------------------------------------------------
 Назначение: Просмотр комментариев компании
=====================================================
*/

include( "./defaults.php" );

$kPage = empty($_GET['page']) ? 0 : intval($_GET['page']);

if (!isset($_SESSION['random']))
{
	$_SESSION['random'] = mt_rand(1000000, 9999999);
}

$rand = mt_rand(1, 999);

function buildRate($id, $val, $inside = 0)
{
	$val = round($val);
	if (!$inside) $rate_img='<div id="rateWrap'.$id.'" class="rateWrap">';

	$rate_img.='<div id="rate'.$id.'">';
	for ($i = 1; $i <= 5; ++$i) {
                if ($val >= $i) $rateOn='rateOn'; else $rateOn='';
		$rate_img.= "<a href=\"#\" class=\"rateItem $rateOn\"
			onclick=\"return rate($id, $i)\"
			onmouseover=\"seeOn(this)\" onmouseout=\"seeOff(this)\"> </a>";
        }
	$rate_img.= '</div>';
	$rate_img.= '<img id="ratePic'.$id.'" src="images/go.gif" border="0" style="display: none">';
	$rate_img.= '<br>';
	if (!$inside) $rate_img.= '</div>';

        return $rate_img;
}

if ( !empty($_REQUEST['rate']) )
{
	$_REQUEST['rate'] = (int)$_REQUEST['rate'];
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_reviews WHERE id = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['rateimg']) ? array() : explode(',', $_COOKIE['rateimg']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('rateimg', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_reviews SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE id='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}


$r = $db->query("SELECT * FROM $db_users WHERE selector='$id'");

$ra = $db->query("SELECT * FROM $db_users WHERE selector = '$id' $hide_d");
$fa = $db->fetcharray($ra);

$cat_firm = 0;
$maincategory = "";

$subcategory = 0;
$mainsubcategory = "";

$subsubcategory = 0;
$mainsubsubcategory = "";

$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

if ($cat != 0)
{
	$res = $db->query("SELECT * FROM $db_category WHERE selector = '$cat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showmaincategory = $fe["category"];
	$cat_firm = $fe[selector];

	if ($def_rewrite == "YES")
	{
		$incomingline.= "<a href=\"$def_mainlocation/" . str_replace(' ', "_", rewrite($showmaincategory)) . "/$cat-$kPage.html\">";
	}
	else
	{
		$incomingline.= "<a href=\"index.php?category=$cat\">";
	}

	$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
}


if ($subcat != 0)
{
	$res = $db->query("SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showcategory = $fe["subcategory"];
	$subcategory = $fe[catsubsel];

	if ($def_rewrite == "YES")
	{
		$incomingline.= " | <a href=\"$def_mainlocation/" . str_replace(' ', "_", rewrite($showmaincategory)) . "/" . str_replace(' ', "_", rewrite($showcategory)) . "/$cat-$subcat-$kPage.html\">";
	}
	else
	{
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";
	}

	$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
}

if ($subsubcat != 0)
{
	$res = $db->query("SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'");
	$fe = $db->fetcharray($res);
	$db->freeresult($res);
	$showsubcategory = $fe["subsubcategory"];
	$subsubcategory = $fe[catsubsubsel];

	if ($def_rewrite == "YES")
	{
		$incomingline.= " | <a href=\"$def_mainlocation/" . str_replace(' ', "_", rewrite($showmaincategory)) . "/" . str_replace(' ', "_", rewrite($showcategory)) . "/" . str_replace(' ', "_", rewrite($showsubcategory)) . "/$cat-$subcat-$subsubcat-$kPage.html\">";
	}
	else
	{
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$kPage\">";
	}

	$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
}

// Формируем ЧПУ для компании

if (($cat_firm == "") and ($subcategory == "") and ($subsubcategory == ""))
{
	$links_view = "$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
}
if (($cat_firm != 0) and ($subcategory == 0) and ($subsubcategory == 0))
{
	$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/$cat_firm-0-0-$id-$kPage-0.html";
}
if (($subcategory != 0) and ($subsubcategory == 0))
{
	$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/" . rewrite($showcategory) . "/$cat_firm-$subcategory-0-$id-$kPage-0.html";
}
if ($subsubcategory != 0)
{
	$links_view = "$def_mainlocation/" . rewrite($showmaincategory) . "/" . rewrite($showcategory) . "/" . rewrite($showsubcategory) . "/$cat_firm-$subcategory-$subsubcategory-$id-$kPage-0.html";
}

if ($def_rewrite == "YES")
{
	$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_view_reviews";
}
else
{
	$incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fa[firmname]</u></font></a> | $def_view_reviews";
}

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

$rtype_page='';
if (isset($_GET['type'])) { $rtype_t=''; $rtype_t=intval($_GET['type']); $rtype_where=" and rtype='$rtype_t' "; $rtype_page="&amp;type=$rtype_t"; }

$r_all = $db->query  ( "SELECT * FROM $db_reviews WHERE company='$id' and status='on' $rtype_where" );
@$results_amount_all = mysql_num_rows ( $r_all );

if ((isset($_GET['type'])) and ($results_amount_all==0)) $def_mailid_error=$def_review_nottype; else {

$rz = $db->query("SELECT * FROM $db_reviews WHERE company='$id' and status='on' $rtype_where ORDER BY id DESC LIMIT $page1, $def_info_page");

@$results_amount = mysql_num_rows ( $rz );

}

$help_section = $review2_help;

$incomingline_firm = "$def_view_reviews &raquo; $fa[firmname]";

include ( "./template/$def_template/header.php" );

if ( ( isset ( $_GET['review_status'] ) ) and ( $_GET['review_status'] == "off" ) ) echo '<br><div style="color:#FF0000; padding: 10px; text-align:center;">'.$def_review_approved.'</div><br>';

main_table_top($def_review);

?>

<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<? echo "$def_mainlocation/includes/css/"; ?>rate.css">

<?

if ($results_amount > 0)
{
	include ("./includes/sub.php");

	echo "<noindex><div align=\"right\"><a rel=\"nofollow\" href=\"$def_mainlocation/reviews.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=1\">$def_review_type_com_view</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/reviews.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=2\">$def_review_type_good_view</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/reviews.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=3\">$def_review_type_bad_view</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/reviews.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">$def_all_filter</a></div></noindex>";

	include ("./includes/catreview.php");
        
	// Страницы

        echo '<br><br>';

	if ( $results_amount_all > $def_info_page )

	{
		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount_all) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount_all;

		@$z=$first/$def_info_page;

		if ($kPage > 0)

		{
			if (($def_rewrite == "YES") and (empty($rtype_t))) echo "<a href=\"$def_mainlocation/view-reviews-$id-$cat-$subcat-$subsubcat-", $kPage-1 ,".html\"><b>$def_previous</b></a>&nbsp;";
			else echo "<a href=\"reviews.php?id=$id&page=", $kPage-1 ,"&cat=$cat_firm&subcat=$subcategory&subsubcat=$subsubcategory$rtype_page\"><b>$def_previous</b></a>&nbsp;";
		}

		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{
			if ( $z == $kPage )

			{
				echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
				$z++;
			}

			else

			{
				if (($def_rewrite == "YES") and (empty($rtype_t))) echo "<a href=\"$def_mainlocation/view-reviews-$id-$cat-$subcat-$subsubcat-$z.html\"><b>", $z+1 ,"</b></a>&nbsp;";
				else echo "<a href=\"reviews.php?id=$id&page=$z&cat=$cat_firm&subcat=$subcategory&subsubcat=$subsubcategory$rtype_page\"><b>", $z+1 ,"</b></a>&nbsp;";
				$z++;
			}
		}

                if ($kPage - (($results_amount_all / $def_info_page) - 1) < 0)

                {
        		if (($def_rewrite == "YES") and (empty($rtype_t))) echo "<a href=\"$def_mainlocation/view-reviews-$id-$cat-$subcat-$subsubcat-", $kPage+1 ,".html\"><b>$def_next</b></a>";
        		else echo "<a href=\"reviews.php?id=$id&&page=", $kPage+1 ,"&cat=$cat_firm&subcat=$subcategory&subsubcat=$subsubcategory$rtype_page\"><b>$def_next</b></a>";
                }
	}
	
	$curUrl = "review.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat";
	
	require 'includes/loginza/init.php';
	require './includes/review_form.php'; 
}
else
{
	if ( ( empty ( $_GET['review_status'] ) ) and ( $_GET['review_status'] != "off" ) ) echo "<font color=\"red\"><br>&nbsp;$def_mailid_error</font>";
}



main_table_bottom();

include ( "./template/$def_template/footer.php" );
?>