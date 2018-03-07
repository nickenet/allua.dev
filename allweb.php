<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: allweb.php
-----------------------------------------------------
 Назначение: Сайты организаций каталога
=====================================================
*/


include ( "./defaults.php" );
$help_section = $catweb_help;

if (isset($_POST['go_subcat_web'])) $_SESSION['go_subcat_web']=safeHTML($_POST['go_subcat_web']);

// Определяем тариф

$zapros_tarif="";
if ( $def_D_www != "YES") $zapros_tarif=" and flag <> 'D'";
if ( $def_C_www != "YES") $zapros_tarif=" and flag <> 'C'";
if ( $def_B_www != "YES") $zapros_tarif=" and flag <> 'B'";
if ( $def_A_www != "YES") $zapros_tarif=" and flag <> 'A'";

// ################# Выводим каталог с категориями

if (!isset($_GET['category'] ))

{
    
// статистика по сайтам

$fileweb = 'system/webstat.dat';
if (file_exists($fileweb)) {
    $day_s=date ("d");
    $date_web=date ("d", filemtime($fileweb));
    if (($day_s!=$date_web) or (filesize($fileweb)==0)) {

        @$rstat1 = $db->query ( "SELECT SUM(webcounter) as sumweb  FROM $db_users  WHERE firmstate = 'on' and www != '' $zapros_tarif " );
        @$f_stat1 = $db->fetcharray ( $rstat1 );
        @$rstat2=$db->query ("select COUNT(selector) from $db_users where firmstate = 'on' and www != '' $zapros_tarif ") ;
        @$f_stat2=mysql_result($rstat2, 0 ,0);
        $tmp=$f_stat1['sumweb'].':'.$f_stat2;
        if ($tmp!=":") @file_put_contents('system/webstat.dat', $tmp);

    }
}

####################################

$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$def_title_web</font>";

$incomingline_firm=$def_title_web;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

echo phighslide();

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

 $template_view_web_category = set_tFile('category_web.tpl');

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_web.php';
 }

 echo "<br /> <br />
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );

        if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_web.php';
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php

$rz = $db->query ( "SELECT selector, category, firmname, business, www, webcounter, rating, votes, social  FROM $db_users  WHERE firmstate = 'on' and www!='' $zapros_tarif ORDER BY webcounter DESC LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

main_table_top  ($def_top_site_10);

    $last10_offers="YES";

    include ("./includes/sub_component/catweb.php");

    include ("./includes/sub_component/statweb.php");

main_table_bottom();

}

}

else

{

// ###################### Выборка сайтов из категории

$def_count_srch=20; // сколько выводить сайтов на странице

$category_web=intval($_GET['category']);

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;

	$r1 = $db->query ( "SELECT category, sccounter, selector FROM $db_category WHERE selector= '$category_web'" );
	$f1= $db->fetcharray($r1);

$title_web_cat=$f1[category].". ".$def_title_web;

if ($def_rewrite == "YES") $url_allweb=$def_mainlocation.'/site/'; else $url_allweb=$def_mainlocation.'/allweb.php';

$incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$url_allweb.'"><font color="'.$def_status_font_color.'"><u>'.$def_title_web.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1['category'].'</font>';

$incomingline_firm=$title_web_cat;

include ( "./template/$def_template/header.php" );

echo phighslide();

// Даем пользователю право выбора типа

if (isset($_GET["page"])) $pages_offers="&amp;page=$kPage";

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
                            if ($_SESSION['go_subcat_web']==$f1['selector'].'#'.$f2['selsub'].'#0') $selected_v='selected'; else $selected_v='';
                            if ($_SESSION['go_subcat_web']==$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel']) $selected_v2='selected'; else $selected_v2='';
                            if ($f2['ssccounter']>0) $razdel .= '<option disabled="disabled" value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            else $razdel .= '<option '.$selected_v.' value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            if ($f2['selsub']==$f2['catsubsel']) $razdel .= '<option '.$selected_v2.' value="'.$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel'].'">&nbsp;&nbsp;&nbsp;'.$f2['subsubcategory'].'</option>';
			}
}

include ( "./template/$def_template/sort_web_cat.php" ); // Подключаем шаблон сортировки

        if ((isset($_GET['sort'])) or (isset($_SESSION['sort_web_site'])))

        {
            if (isset($_GET['sort'])) $_SESSION['sort_web_site']=intval($_GET['sort']);
	
		switch ($_SESSION['sort_web_site']) {
			  case 2:
			    $o_sort=" ORDER BY firmname";
			    break;
			  case 1:
			    $o_sort=" ORDER BY date";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY webcounter DESC";
		}
        }

	else $o_sort=" ORDER BY webcounter DESC";


main_table_top($title_web_cat);

$main_cat=explode("#",$_SESSION['go_subcat_web']);

if ($main_cat[0]!=$_GET['category']) unset($_SESSION['go_subcat_web']);

if (empty($_SESSION['go_subcat_web']) or ($_SESSION['go_subcat_web']=="ALL")) {
    $like_sql1="$categorymains#%#%:%";
    $like_sql2="%:$categorymains#%#%:%";
    $like_sql3="%:$categorymains#%#%";
    $like_sql4="$categorymains#%#%";
} else {
    $like_sql1=$_SESSION['go_subcat_web'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_web'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_web'];
    $like_sql4=$_SESSION['go_subcat_web'];
}

$r1 = $db->query ( "SELECT selector, category, firmname, business, www, webcounter, rating, votes, social, map  FROM $db_users WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' and www!='' $zapros_tarif");
@$result_in=mysql_num_rows ( $r1 );

$rz = $db->query ( "SELECT selector, category, firmname, business, www, webcounter, rating, votes, social, map  FROM $db_users WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' and www!='' $zapros_tarif $o_sort LIMIT $page1, $def_count_srch" );
@$results_amount = mysql_num_rows ( $rz );


if ( $results_amount > 0 )

{
    
include ("./includes/sub_component/catweb.php");

// Подключение карты

$string_where='cat='.$category_web.'&subcat='.$subcat.'&fetchcounter='.$results_amount.'&page1='.$page1.'&def_count_dir='.$def_count_srch;

?>

<script src="https://api-maps.yandex.ru/2.0.20/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    $('#maps').click( function() {

        $.ajax({
          type: 'POST',
          url: '<?php echo $def_mainlocation; ?>/includes/ajax/maps_firms_site.php',
          data: '<?php echo $string_where; ?>',
          beforeSend: function() { $('#results_map').html('<img src="<?php echo $def_mainlocation; ?>/images/go.gif">'); },
          success: function(data){
            $('#results_map').html(data);
          }
        });

    });
</script>

<?php

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
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_web.'-site'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/allweb.php?category='.$category_web.'"><b>'.$def_previous.'</b></a>&nbsp;';
            } else {
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_web.'-site'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/allweb.php?category='.$category_web.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';
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
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_web.'-site'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/allweb.php?category='.$category_web.'"><b>'.($z+1).'</b></a>&nbsp;';
                    } else {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_web.'-site'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.$z.'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/allweb.php?category='.$category_web.'&page='. $z.'"><b>'.($z+1).'</b></a>&nbsp;';
                    }
			$z++;
		}
	}

	if ($kPage - (($result_in / $def_count_srch) - 1) < 0) {

            if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$category_web.'-site'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;';
            else $next_page = '<a href="'.$def_mainlocation.'/allweb.php?category='.$category_web.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';
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

echo '<div style="text-align: left; padding: 0 5px">'.$def_web_sum.' - <b>'.$result_in.'</b></div>';

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