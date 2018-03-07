<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: allinfo.php
-----------------------------------------------------
 Назначение: Публикации
=====================================================
*/

include ( "./defaults.php" );
$help_section = $allinfo_help;

$kPage = intval($_REQUEST['page']);
$kType = intval ($_REQUEST['type']);

if (isset($_POST['go_subcat_info'])) $_SESSION['go_subcat_info']=safeHTML($_POST['go_subcat_info']);

if ( ($kType==0) or ($kType>5) or ($kType<0) ) $kType=1;

$type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

$title_info="$type_on[$kType] $def_info_title_comany";

if ($kType==1) { $name_type="news"; $name_url_info="inews"; }
if ($kType==2) { $name_type="tender"; $name_url_info="itender"; }
if ($kType==3) { $name_type="board"; $name_url_info="iboard"; }
if ($kType==4) { $name_type="job"; $name_url_info="ijob"; }
if ($kType==5) { $name_type="pressrel"; $name_url_info="ipressrel"; }


// ################# Выводим каталог с категориями

if (!isset($_GET['category']))

{

$incomingline = "<a href=\"$def_mainlocation/index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_info</font>";

$incomingline_firm=$title_info;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

include ("./includes/searchinfo.inc.php");

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
 
 $template_view_info_category = set_tFile('category_info.tpl');

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_info.php';

 }


 echo "<br /> <br /> 
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );

        if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_info.php';
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php

$re = $db->query ( "SELECT * FROM $db_info WHERE type='$kType' ORDER BY date DESC, datetime DESC LIMIT 10");
@$results_amount_2 = mysql_num_rows ( $re );

if ( $results_amount_2 > 0 )

{

$title_last_info="$type_on[$kType] $def_info_title_view";

main_table_top  ($title_last_info);

$modul_info="YES";

include ("./includes/sub_component/pubsub.php");


main_table_bottom();

}

}

else

{

// ###################### Выборка публикаций из категории

$category_info=intval($_GET['category']);

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;


	$r1 = $db->query ( "SELECT category, sccounter, selector FROM $db_category WHERE fcounter>0 and selector= '$category_info'" );
	$f1= $db->fetcharray($r1);

$title_info_cat=$f1[category].". ".$title_info;

if ($def_rewrite == "YES") $url_allinfo=$def_mainlocation.'/'.$name_url_info.'/'; else $url_allinfo=$def_mainlocation.'/allinfo.php?type='.$kType;

$incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$url_allinfo.'"><font color="'.$def_status_font_color.'"><u>'.$title_info.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1['category'].'</font>';

$incomingline_firm=$title_info_cat;

include ( "./template/$def_template/header.php" );

// Даем пользователю право выбора типа

if (isset($_GET["page"])) $pages_info="&amp;page=$kPage";

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
                            if ($_SESSION['go_subcat_info']==$f1['selector'].'#'.$f2['selsub'].'#0') $selected_v='selected'; else $selected_v='';
                            if ($_SESSION['go_subcat_info']==$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel']) $selected_v2='selected'; else $selected_v2='';
                            if ($f2['ssccounter']>0) $razdel .= '<option disabled="disabled" value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            else $razdel .= '<option '.$selected_v.' value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            if ($f2['selsub']==$f2['catsubsel']) $razdel .= '<option '.$selected_v2.' value="'.$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel'].'">&nbsp;&nbsp;&nbsp;'.$f2['subsubcategory'].'</option>';
			}
}

include ( "./template/$def_template/sort_info_cat.php" ); // Подключаем шаблон сортировки


	if ((isset($_GET['sort'])) or (isset($_SESSION['sort_info_cat'])))
	{
               if (isset($_GET['sort'])) $_SESSION['sort_info_cat']=intval($_GET['sort']);
	
		switch ($_SESSION['sort_info_cat']) {
			  case 1:
			    $o_sort=" ORDER BY show_info DESC";
			    break;
			  case 2:
			    $o_sort=" ORDER BY firmname";
			    break;
			  case 4:
			    $o_sort=" ORDER BY item";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY date DESC, datetime DESC";
		}
	}

	else $o_sort=" ORDER BY date DESC, datetime DESC";

main_table_top($title_info_cat);

$main_cat=explode("#",$_SESSION['go_subcat_info']);

if ($main_cat[0]!=$_GET['category']) unset($_SESSION['go_subcat_info']);

if (empty($_SESSION['go_subcat_info']) or ($_SESSION['go_subcat_info']=="ALL")) {
    $like_sql1="$categorymains#%#%:%";
    $like_sql2="%:$categorymains#%#%:%";
    $like_sql3="%:$categorymains#%#%";
    $like_sql4="$categorymains#%#%";
} else
{
    $like_sql1=$_SESSION['go_subcat_info'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_info'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_info'];
    $like_sql4=$_SESSION['go_subcat_info'];
}

$re_all = $db->query  ( "SELECT num FROM $db_info WHERE type='$kType' and (category LIKE '$like_sql1' or category LIKE '$like_sql2' or category LIKE '$like_sql3' or category LIKE '$like_sql4') $o_sort" );
@$results_amount = mysql_num_rows ( $re_all );

$re = $db->query  ( "SELECT * FROM $db_info WHERE type='$kType' and (category LIKE '$like_sql1' or category LIKE '$like_sql2' or category LIKE '$like_sql3' or category LIKE '$like_sql4') $o_sort LIMIT $page1, $def_info_page" );
@$results_amount_2 = mysql_num_rows ( $re );

if ( $results_amount_2 > 0 )

{

	$modul_info="YES";

	include ("./includes/sub_component/pubsub.php");

	// Страницы

	if ( $results_amount > $def_info_page )

	{
            
                $prev_page=''; $page_news=''; $next_page='';

		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount;

		@    $z=$first/$def_info_page;
                
                if ($kPage > 0) {

                    $z_prev=$kPage-1;
                    if ($z_prev==0) {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_info.'-'.$name_url_info.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                        else $prev_page = '<a href="'.$def_mainlocation.'/allinfo.php?category='.$category_info.'&type='.$kType.'"><b>'.$def_previous.'</b></a>&nbsp;';
                    } else {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_info.'-'.$name_url_info.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                        else $prev_page = '<a href="'.$def_mainlocation.'/allinfo.php?category='.$category_info.'&page='.($kPage-1).'&type='.$kType.'"><b>'.$def_previous.'</b></a>&nbsp;';
                    }
                }                

		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{
			if ( $z == $kPage )

			{
				$page_news.= '[ <b>'. ($z+1) .'</b> ]&nbsp;';
				$z++;
			}

			else

			{

                            if ($z==0) {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_info.'-'.$name_url_info.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.($z+1).'</b></a>&nbsp;';
                                else $page_news.= '<a href="'.$def_mainlocation.'/allinfo.php?category='.$category_info.'&type='.$kType.'"><b>'.($z+1).'</b></a>&nbsp;';
                            } else {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_info.'-'.$name_url_info.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.$z.'/"><b>'.($z+1).'</b></a>&nbsp;';
                                else $page_news.= '<a href="'.$def_mainlocation.'/allinfo.php?category='.$category_info.'&page='. $z.'&type='.$kType.'"><b>'.($z+1).'</b></a>&nbsp;';
                            }
				$z++;
			}
		}
                
                if ($kPage - (($results_amount / $def_info_page) - 1) < 0) {
                    if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$category_info.'-'.$name_url_info.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;';
                    else $next_page = '<a href="'.$def_mainlocation.'/allinfo.php?category='.$category_info.'&page='.($kPage+1).'&type='.$kType.'"><b>'.$def_next.'</b></a>&nbsp;';
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
        
        echo '<div style="text-align: left; padding: 0 5px">'.$def_info_sum.' - <b>'.$results_amount.'</b></div>';
	
 }

 else

 {
         $def_title_error = $def_warning_msg;
         $def_message_error = $def_nopublic;

         include ( "./includes/error_page.php" );
 }

main_table_bottom();

}

$db->freeresult ( $re );

include ( "./template/$def_template/footer.php" );

?>