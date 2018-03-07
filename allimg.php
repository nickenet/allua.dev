<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & M.Lomakin
=====================================================
 Файл: allimg.php
-----------------------------------------------------
 Назначение: Галерея изображений компаний
=====================================================
*/

include ( "./defaults.php" );

if (isset($_POST['go_subcat_img'])) $_SESSION['go_subcat_img']=safeHTML($_POST['go_subcat_img']);

if (empty($_SESSION['gallery'])) $_SESSION['gallery'] = $def_gallery_outputmethod;
if ($_GET[output] == 'gallery' or ($_SESSION['gallery'] == 'gallery' and $_GET[output] == ''))  {
    $_SESSION['gallery'] = 'gallery';
    $templ_gal = 'gallery_gallery.tpl';
    $active1 = 'active';
    $def_count_srch = $def_gallery_gallery;
}
if ($_GET[output] == 'list' or ($_SESSION['gallery'] == 'list' and $_GET[output] == '')) {
    $_SESSION['gallery'] = 'list';
    $templ_gal = 'gallery_list.tpl';
    $active2 = 'active';
}
if ($_GET[output] == 'list_full' or ($_SESSION['gallery'] == 'list_full' and $_GET[output] == '')) {
    $_SESSION['gallery'] = 'list_full';
    $templ_gal = 'gallery_list.tpl';
    $active3 = 'active';
 }
 
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
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_images WHERE num = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['rateimg']) ? array() : explode(',', $_COOKIE['rateimg']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('rateimg', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_images SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE num='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}

$kPage = intval($_GET['page']);

$help_section = $img_help;

// ################# Выводим каталог с категориями

if (!isset($_GET['category'] ))

{

$incomingline = "<a href=\"$def_mainlocation/index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$def_img_title</font>";

$incomingline_firm=$def_img_title;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

include ("./includes/searchimg.inc.php");

echo phighslide();

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/filter.js"></script>
<link rel="stylesheet" href="<?php echo "$def_mainlocation/includes/css/"; ?>rate.css">

<br />
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
   <tr>
    <td width="100%" valign="top" align="center">
     <table cellspacing="0" cellpadding="0" border="0" width="90%">
      <tr>
       <td width="50%" valign="top">
<?php

 $r = $db->query ( "SELECT selector, category, img, fcounter FROM $db_category WHERE fcounter>0 ORDER BY category " );
 
	if (!$r) error ("mySQL error", mysql_error() );

 $results = $db->numrows ( $r );

 $res = round ( $results/2 );

 $template_view_img_category = set_tFile('category_img.tpl');

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_img.php';
 }


 echo "<br /> <br /> 
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_img.php';
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php
 
main_table_top ($def_img_new);

$categoty_set='';

$link_type_list = $def_mainlocation.'/allimg.php?';

include ( "./template/$def_template/type_list.php" ); // Подключаем шаблон выбора типа трансляции

include ( "./template/$def_template/category_filter.php" ); // Подключаем шаблон ссылок по фильтру

if ($_SESSION['gallery'] == 'gallery') $limit_main=9; else $limit_main=10;

$rz = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_images.rateNum, $db_images.rateVal, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE firmstate = 'on' ORDER BY $db_images.date DESC, $db_images.num DESC LIMIT $limit_main");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

	$filter_img="newimg";
	$def_image_company="YES";

		include ("./includes/sub_component/catgallery.php");
}

$rz = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_images.rateNum, $db_images.rateVal, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE firmstate = 'on' ORDER BY $db_images.rateVal DESC, $db_images.rateNum DESC LIMIT $limit_main");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

	$filter_img="rateVal";
	$def_image_company="YES";

		include ("./includes/sub_component/catgallery.php");
}

$rz = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_images.rateNum, $db_images.rateVal, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE firmstate = 'on' ORDER BY RAND() LIMIT $limit_main");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

	$filter_img="randomimg";
	$def_image_company="YES";

		include ("./includes/sub_component/catgallery.php");

}

main_table_bottom();

}

else

{

// ###################### Выборка продукции из категории

$category_img=intval($_GET['category']);

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;


	$r1 = $db->query ( "SELECT category, sccounter, selector FROM $db_category WHERE fcounter>0 and selector= '$category_img'" );
	$f1= $db->fetcharray($r1);

$def_xls_title_cat=$f1['category'].". ".$def_img_title;

if ($def_rewrite == "YES") $url_allimg=$def_mainlocation.'/gallery/'; else $url_allimg=$def_mainlocation.'/allimg.php';

$incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$url_allimg.'"><font color="'.$def_status_font_color.'"><u>'.$def_img_title.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1[category].'</font>';

$incomingline_firm=$def_xls_title_cat;

include ( "./template/$def_template/header.php" );

echo phighslide();

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo "$def_mainlocation/includes/css/"; ?>rate.css">

<?php

if (isset($_GET['page'])) $pages_offers="&amp;page=$kPage";

if ($f1['sccounter']>0) {

    $sql = 'SELECT o.catsel, o.subcategory, o.catsubsel as selsub, o.ssccounter, u.catsubsel,u.catsubsubsel, u.subsubcategory FROM ' . $db_subcategory . ' AS o
		LEFT JOIN ' . $db_subsubcategory . ' AS u ON u.catsubsel = o.catsubsel
		WHERE o.catsel='.$f1[selector].' and o.fcounter>0
		ORDER BY o.subcategory';

    $r2 = $db->query ( "$sql" );
    @$results_amount_subcat = mysql_num_rows ( $r2 );
    $razdel='';
    			for($x=0; $x<$results_amount_subcat; $x++)
			{
                        $f2 = $db->fetcharray  ( $r2 );
                            if ($_SESSION['go_subcat_img']==$f1['selector'].'#'.$f2['selsub'].'#0') $selected_v='selected'; else $selected_v='';
                            if ($_SESSION['go_subcat_img']==$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel']) $selected_v2='selected'; else $selected_v2='';
                            if ($f2['ssccounter']>0) $razdel .= '<option disabled="disabled" value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            else $razdel .= '<option '.$selected_v.' value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            if ($f2['selsub']==$f2['catsubsel']) $razdel .= '<option '.$selected_v2.' value="'.$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel'].'">&nbsp;&nbsp;&nbsp;'.$f2['subsubcategory'].'</option>';
			}
}

include ( "./template/$def_template/sort_img_cat.php" ); // Подключаем шаблон сортировки

$link_type_list = $def_mainlocation.'/allimg.php?category='.$category_img.'&';

include ( "./template/$def_template/type_list.php" ); // Подключаем шаблон выбора типа трансляции

	if ((isset($_GET['sort'])) or (isset($_SESSION['sort_img_gal'])))
	{

	if (isset($_GET['sort'])) $_SESSION['sort_img_gal']=intval($_GET['sort']);
	
		switch ($_SESSION['sort_img_gal']) {
			  case 2:
			    $o_sort=" ORDER BY $db_users.flag, $db_users.firmname";
			    break;
			  case 3:
			    $o_sort=" ORDER BY $db_users.flag, $db_images.item";
			    break;
			  case 4:
			    $o_sort=" ORDER BY $db_images.rateVal DESC, $db_images.rateNum DESC";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY $db_users.flag, $db_images.date DESC";
		}
	}

	else $o_sort=" ORDER BY $db_users.flag, $db_images.date DESC";

$main_cat=explode("#",$_SESSION['go_subcat_img']);

if ($main_cat[0]!=$_GET['category']) unset($_SESSION['go_subcat_img']);

main_table_top($def_xls_title_cat);

if (empty($_SESSION['go_subcat_img']) or ($_SESSION['go_subcat_img']=="ALL")) {
    $like_sql1="$categorymains#%#%:%";
    $like_sql2="%:$categorymains#%#%:%";
    $like_sql3="%:$categorymains#%#%";
    $like_sql4="$categorymains#%#%";
} else
{
    $like_sql1=$_SESSION['go_subcat_img'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_img'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_img'];
    $like_sql4=$_SESSION['go_subcat_img'];
}


$r1 = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_images.rateNum, $db_images.rateVal, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' ");
@$result_in=mysql_num_rows ( $r1 );

$rz = $db->query ( "SELECT $db_images.num, $db_images.firmselector, $db_images.item, $db_images.date, $db_images.message, $db_images.rateNum, $db_images.rateVal, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_images  INNER JOIN $db_users ON $db_images.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' $o_sort LIMIT $page1, $def_count_srch" );
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 )

{

$def_image_company="YES";

include ("./includes/sub_component/catgallery.php");

// Страницы

if ( $result_in > $def_count_srch )

{
        $prev_page=''; $page_news=''; $next_page='';

	if ((($kPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($kPage*$def_count_srch)+($def_count_srch*6)) <= $result_in) $last =($kPage*$def_count_srch)+($def_count_srch*6);
	else $last = $result_in;

	@    $z=$first/$def_count_srch;

	if ($kPage > 0) {

            $z_prev=$kPage-1;
            if ($z_prev==0) {
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_img.'-gallery'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/allimg.php?category='.$category_img.'"><b>'.$def_previous.'</b></a>&nbsp;';
            } else {
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_img.'-gallery'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/allimg.php?category='.$category_img.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';
            }
        }

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_count_srch )
	{
		if ( $z == $kPage )

		{
			$page_news.= '[ <b>'. ($z+1) .'</b> ]&nbsp;';
			$z++;
		}

		else

		{
                    if ($z==0) {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_img.'-gallery'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/allimg.php?category='.$category_img.'"><b>'.($z+1).'</b></a>&nbsp;';
                    } else {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_img.'-gallery'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.$z.'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/allimg.php?category='.$category_img.'&page='. $z.'"><b>'.($z+1).'</b></a>&nbsp;';
                    }
			$z++;
		}
	}

	if ($kPage - (($result_in / $def_count_srch) - 1) < 0) {

            if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$category_img.'-gallery'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;';
            else $next_page = '<a href="'.$def_mainlocation.'/allimg.php?category='.$category_img.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';
        }
        
        include ( "./template/$def_template/pages.php" ); // подключаем обработку страниц

        $template_page_news = set_tFile('pages.tpl');

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

}

echo '<div style="text-align: left; padding: 0 5px">'.$def_img_sum.' - <b>'.$result_in.'</b></div>';

}

else {

    $def_title_error = $def_warning_msg;
    $def_message_error = $def_not_error;

    include ( "./includes/error_page.php" );

}

main_table_bottom();

}

$db->freeresult ( $fz );

include ( "./template/$def_template/footer.php" );

?>