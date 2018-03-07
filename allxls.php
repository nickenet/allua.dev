<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: allxls.php
-----------------------------------------------------
 Назначение: Прайс-листы организаций
=====================================================
*/

include ( "./defaults.php" );

if (isset($_POST['go_subcat_xls'])) $_SESSION['go_subcat_xls']=safeHTML($_POST['go_subcat_xls']);

$help_section = $xls_help;

// ################# Выводим каталог с категориями

if (!isset($_GET['category'] ))

{

$incomingline = "<a href=\"$def_mainlocation/index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$def_xls_title</font>";

$incomingline_firm=$def_xls_title;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

include ("./includes/searchxls.inc.php");

?>

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

 $template_view_xls_category = set_tFile('category_price.tpl');

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_xls.php';
 }

 echo "<br /> <br /> 
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )
 
 {
 	$f = $db->fetcharray ( $r );

        if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_xls.php';
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php

$rz = $db->query ( "SELECT $db_exelp.num, $db_exelp.firmselector, $db_exelp.item, $db_exelp.date, $db_exelp.message, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_exelp  INNER JOIN $db_users ON $db_exelp.firmselector = $db_users.selector WHERE firmstate = 'on' ORDER BY $db_exelp.date DESC LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 )

{

main_table_top  ($def_xls_new);

    $last10_xls="YES";

    $allxls="YES";

    require 'includes/sub_component/price_view.php';

main_table_bottom();

}

}

else

{

// ###################### Выборка продукции из категории

$category_xls=intval($_GET['category']);

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;

	$r1 = $db->query ( "SELECT category, sccounter, selector FROM $db_category WHERE fcounter>0 and selector= '$category_xls'" );
	$f1= $db->fetcharray($r1);

$def_xls_title_cat=$f1['category'].". ".$def_xls_title;

if ($def_rewrite == "YES") $url_allxls=$def_mainlocation.'/price/'; else $url_allxls=$def_mainlocation.'/allxls.php';

$incomingline = "<a href=\"$def_mainlocation/index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <a href=\"$url_allxls\"><font color=\"$def_status_font_color\"><u>$def_xls_title</u></font></a> | <font color=\"$def_status_font_color\">$f1[category]</font>";

$incomingline_firm=$def_xls_title_cat;

include ( "./template/$def_template/header.php" );

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
                            if ($_SESSION['go_subcat_xls']==$f1['selector'].'#'.$f2['selsub'].'#0') $selected_v='selected'; else $selected_v='';
                            if ($_SESSION['go_subcat_xls']==$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel']) $selected_v2='selected'; else $selected_v2='';
                            if ($f2['ssccounter']>0) $razdel .= '<option disabled="disabled" value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            else $razdel .= '<option '.$selected_v.' value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            if ($f2['selsub']==$f2['catsubsel']) $razdel .= '<option '.$selected_v2.' value="'.$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel'].'">&nbsp;&nbsp;&nbsp;'.$f2['subsubcategory'].'</option>';
			}
}

include ( "./template/$def_template/sort_xls_cat.php" ); // Подключаем шаблон сортировки

	if ((isset($_GET['sort'])) or (isset($_SESSION['sort_xls_all'])))
	{
	if (isset($_GET['sort'])) $_SESSION['sort_xls_all']=intval($_GET['sort']);
	
		switch ($_SESSION['sort_xls_all']) {
			  case 2:
			    $o_sort=" ORDER BY $db_users.flag, $db_users.firmname";
			    break;
			  case 3:
			    $o_sort=" ORDER BY $db_users.flag, $db_exelp.item";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY $db_users.flag, $db_exelp.date DESC";
		}
	}

	else $o_sort=" ORDER BY $db_users.flag, $db_exelp.date DESC";

$main_cat=explode("#",$_SESSION['go_subcat_xls']);

if ($main_cat[0]!=$_GET['category']) unset($_SESSION['go_subcat_xls']);

main_table_top($def_xls_title_cat);

if (empty($_SESSION['go_subcat_xls']) or ($_SESSION['go_subcat_xls']=="ALL")) {
    $like_sql1="$categorymains#%#%:%";
    $like_sql2="%:$categorymains#%#%:%";
    $like_sql3="%:$categorymains#%#%";
    $like_sql4="$categorymains#%#%";
} else
{
    $like_sql1=$_SESSION['go_subcat_xls'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_xls'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_xls'];
    $like_sql4=$_SESSION['go_subcat_xls'];
}

$r1 = $db->query ( "SELECT $db_exelp.num, $db_exelp.firmselector, $db_exelp.item, $db_exelp.date, $db_exelp.message, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_exelp  INNER JOIN $db_users ON $db_exelp.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' ");
@$result_in=mysql_num_rows ( $r1 );

$rz = $db->query ( "SELECT $db_exelp.num, $db_exelp.firmselector, $db_exelp.item, $db_exelp.date, $db_exelp.message, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category FROM $db_exelp  INNER JOIN $db_users ON $db_exelp.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' $o_sort LIMIT $page1, $def_count_srch" );
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 )

{
    $last10_offers="NO";

    $allxls="YES";
	
    require 'includes/sub_component/price_view.php';

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
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_xls.'-price'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'allxls.php?category='.$category_xls.'"><b>'.$def_previous.'</b></a>&nbsp;';
            } else {
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_xls.'-price'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/allxls.php?category='.$category_xls.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';
            }
        }

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_count_srch )
	{
		if ( $z == $kPage )
		{
			$page_news.= '[ <b>'.($z+1).'</b> ]&nbsp;';
			$z++;
		}
		else
		{
                  if ($z==0) {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_xls.'-price'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.($z+1).'</b></a>&nbsp;';
                        else $page_news.= '<a href="'.$def_mainlocation.'/allxls.php?category='.$category_xls.'"><b>'.($z+1).'</b></a>&nbsp;';
                  } else {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_xls.'-price'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.$z.'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/allxls.php?category='.$category_xls.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
                  }
                    $z++;
		}
	}

	if ($kPage - (($result_in / $def_count_srch) - 1) < 0) {
            
            if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$category_xls.'-price'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;';
            else $next_page = '<a href="'.$def_mainlocation.'/allxls.php?category='.$category_xls.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';
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

echo '<br><br><div align="left">'.$def_xls_sum.' - <b>'.$result_in.'</b></div><br><br>';

}

else

echo '<br><br><b>'.$def_not_error.'</b>';

main_table_bottom();

}

$db->freeresult ( $fz );

include ( "./template/$def_template/footer.php" );

?>