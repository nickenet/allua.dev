<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: alloffers.php
-----------------------------------------------------
 Назначение: Каталог продукции и услуг
=====================================================
*/

include ( "./defaults.php" );
$help_section = $catoffers_help;
$title_offers = $def_title_offers;

if (isset($_POST['go_subcat_offer'])) $_SESSION['go_subcat_offer']=safeHTML($_POST['go_subcat_offer']);

if (isset($_REQUEST['print'])) {
    
    if ($_REQUEST['print']=='request') include ("./includes/sub_component/request_print.php"); // Форма печати заявки
    
} else {

if (isset($_GET['full']))

{

	$full_offers=intval($_GET['full']);
	$id_firm=intval($_GET['idfull']);
	$cat_firm=intval($_GET['catfirm']);

	$rf1 = $db->query ( "SELECT category FROM $db_category WHERE selector= '$cat_firm'" );
	$ff1= $db->fetcharray($rf1);

	$r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id_firm'" );
	
	$rz = $db->query  ( "SELECT * FROM $db_offers WHERE num = '$full_offers'" );
	@$results_amount = mysql_num_rows ( $rz );
	$fz = $db->fetcharray  ( $rz );


$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a>
 | <a href=\"alloffers.php\"><font color=\"$def_status_font_color\"><u>$title_offers</u></font></a>
 | <a href=\"alloffers.php?category=$cat_firm\"><font color=\"$def_status_font_color\"><u>$ff1[category]</u></font></a> 
 | <font color=\"$def_status_font_color\">$fz[item]";

$incomingline_firm=$fz['item'] ." - " . $ff1['category'];

session_start();

	header("Cache-control: private");

	if (!isset($_SESSION['random']))
	{
		$_SESSION['random'] = mt_rand(1000000,9999999);
	}

	$rand = mt_rand(1, 999);

$help_section = $catoffers1_help;

include ( "./template/$def_template/header.php" );

echo phighslide();

// ############### Отправляем письмо контрагенту компании

if ( ($_GET[REQ] == "send") and ($_POST[security] != "$_SESSION[random]"))

{

echo "<br><br><div align=\"center\" style=\"border:dashed; background-color:#FFFF00; border-width:1px; width:350px;\"><br><br><b>Код безопасности не соответствует отображённому!</b><br><br><a href=\"javascript:history.go(-1)\"><b>Обновите код!</b></a><br><br></div>";
unset($_SESSION['random']);

}

else

{

if ( ($_GET[REQ] == "send") and ($_POST[security] == "$_SESSION[random]"))

{

	unset($_SESSION['random']);

	if (($_POST[name] != "") and ($_POST[phone] != ""))
	
	{

		$fmail = $db->fetcharray  ( $r );

		if ($fmail['mail']!="") {

                    $img_images = glob('./offer/'.$fz[num].'-small.*');
                    if ($img_images[0]!='') $img_offers='<img src="'.$def_mainlocation.'/offer/'.basename($img_images[0]).'" hspace="3" vspace="3" />'; else $img_offers="";

                    $to = $fmail['mail'];
                    $user=safeHTML($_POST['name']);
                    $phone=safeHTML($_POST['tel']);
                    $mail=safeHTML($_POST['mail']);
                    $company=safeHTML($_POST['firm']);
                    $text=safeHTML(strip_tags($_POST['text']));

                    $template_mail = file_get_contents ('template/' . $def_template . '/mail/offer.tpl');

                    $template_mail = str_replace("*title*", $def_title, $template_mail);
                    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                    $template_mail = str_replace("*firmname*", $fmail['firmname'], $template_mail);
                    $template_mail = str_replace("*id_firm*", $fmail['selector'], $template_mail);
                    $template_mail = str_replace("*title_offer*", $fz['item'], $template_mail);
                    $template_mail = str_replace("*id_offer*", $fz['num'], $template_mail);
                    $template_mail = str_replace("*user*", $user, $template_mail);
                    $template_mail = str_replace("*phone*", $phone, $template_mail);
                    $template_mail = str_replace("*mail*", $mail, $template_mail);
                    $template_mail = str_replace("*company*", $company, $template_mail);
                    $template_mail = str_replace("*text*", $text, $template_mail);
                    $template_mail = str_replace("*offer*", $img_offers, $template_mail);
                    if ($fmail['manager']!='') $template_mail = str_replace("*manager*", $fmail['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

                    mailHTML($to,$def_introductory,$template_mail,$mail);

     		 echo "<br><br><div align=\"center\" style=\"border:dashed; background-color:#FFFF00; border-width:1px; width:350px;\"><br><br><b>Ваше сообщение успешно отправлено!</b><br><br><a href=\"javascript:history.go(-1)\"><b>Для повторной отправки, обновите код!</b></a><br><br></div>";

		} else echo "<br><br><div align=\"center\" style=\"border:dashed; background-color:#FFFF00; border-width:1px; width:500px;\"><br><br><b>К сожалению, у данного контрагента компании, е-mail адрес не занесен в базу!<br> Попробуйте использовать для связи другие контактные данные!</b><br><br></div>";

		$r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id_firm'" );
	}

	else

	{

		if ($_POST[name] == "")  $error1 = "Имя";
		if ($_POST[phone] == "") $error2 = "Телефон";

		echo "<br><br><div align=\"center\" style=\"border:dashed; background-color:#FFFF00; border-width:1px; width:350px;\"><br><br><b><b>ОШИБКА:</b> <font color=red>Заполните пожайлуста поля: $error1 $error2.</font></b><br><br><a href=\"javascript:history.go(-1)\"><b>Для повторной отправки, обновите код!</b></a><br><br></div>";

	}

}
}

// ##################### Выводим продукцию или услугу


include ("./includes/sub.php");

if ($results_amount>0)

{

$last10_offers="NO";
$full_offers_array="YES";

include ("./includes/sub_component/catoffers.php");

if ($f['mail']!='') {

    require 'includes/sub_component/request_offers.php'; // Подключаем форму заявки

    require 'includes/js/alloffers.js'; // Подключаем java

}

}

else

{

    $def_title_error = $def_warning_msg;
    $def_message_error = $def_offers_not_view;

    include ( "./includes/error_page.php" );

}
}

else

{

// ################# Выводим каталог с категориями

if (!isset($_GET['category'] ))

{

$incomingline = "<a href=\"$def_mainlocation/index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_offers</font>";

$incomingline_firm=$title_offers;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

echo phighslide();

include ("./includes/searchoffers.inc.php");

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

 $template_view_img_category = set_tFile('category_offers.tpl');

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_offers.php';
 }


 echo "<br /> <br />
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );

 	if ( $f['fcounter'] > 0 ) require 'includes/sub_component/category_offers.php';
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php


$rz = $db->query ( "SELECT $db_offers.num, $db_offers.type, $db_offers.firmselector, $db_offers.item, $db_offers.date, $db_offers.message, $db_offers.quantity, $db_offers.packaging, $db_offers.price, $db_offers.period, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.manager, $db_users.category  FROM $db_offers  INNER JOIN $db_users ON $db_offers.firmselector = $db_users.selector WHERE firmstate = 'on' ORDER BY $db_offers.date DESC LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );


if ( $results_amount > 0 )

{

$title_last_offers=$def_offers_new;

main_table_top  ($title_last_offers);

$last10_offers="YES";

include ("./includes/sub_component/catoffers.php");

main_table_bottom();

}

}

else

{

// ###################### Выборка продукции из категории

$category_offers=intval($_GET['category']);

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;


	$r1 = $db->query ( "SELECT category, sccounter, selector FROM $db_category WHERE fcounter>0 and selector= '$category_offers'" );
	$f1= $db->fetcharray($r1);

$title_offers_cat=$f1[category].". ".$title_offers;

if ($def_rewrite == "YES") $url_alloffers=$def_mainlocation.'/product/'; else $url_alloffers=$def_mainlocation.'/alloffers.php';

$incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$url_alloffers.'"><font color="'.$def_status_font_color.'"><u>'.$title_offers.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1['category'].'</font>';

$incomingline_firm=$title_offers_cat;

include ( "./template/$def_template/header.php" );

echo phighslide();

// Даем пользователю право выбора типа

if (isset($kPage)) $pages_offers="&page=$kPage";

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
                            if ($_SESSION['go_subcat_offer']==$f1['selector'].'#'.$f2['selsub'].'#0') $selected_v='selected'; else $selected_v='';
                            if ($_SESSION['go_subcat_offer']==$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel']) $selected_v2='selected'; else $selected_v2='';
                            if ($f2['ssccounter']>0) $razdel .= '<option disabled="disabled" value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            else $razdel .= '<option '.$selected_v.' value="'.$f1['selector'].'#'.$f2['selsub'].'#0">'.$f2['subcategory'].'</option>';
                            if ($f2['selsub']==$f2['catsubsel']) $razdel .= '<option '.$selected_v2.' value="'.$f1['selector'].'#'.$f2['selsub'].'#'.$f2['catsubsubsel'].'">&nbsp;&nbsp;&nbsp;'.$f2['subsubcategory'].'</option>';
			}
}

$v_sort1="<a href=\"$def_mainlocation/alloffers.php?category=$category_offers&sort=0$o_page$pages_offers\" title=\"$def_sort_A\"><img src=\"$def_mainlocation/images/sortA.gif\" border=\"0\"></a><a href=\"$def_mainlocation/alloffers.php?category=$category_offers&amp;sort=1$o_page$pages_offers\" title=\"$def_sort_Z\"><img src=\"$def_mainlocation/images/sortZ.gif\" border=\"0\"></a>";
$v_sort2="<a href=\"$def_mainlocation/alloffers.php?category=$category_offers&sort=5$o_page$pages_offers\" title=\"$def_sort_A\"><img src=\"$def_mainlocation/images/sortA.gif\" border=\"0\"></a><a href=\"$def_mainlocation/alloffers.php?category=$category_offers&amp;sort=4$o_page$pages_offers\" title=\"$def_sort_Z\"><img src=\"$def_mainlocation/images/sortZ.gif\" border=\"0\"></a>";
$v_sort3="<a href=\"$def_mainlocation/alloffers.php?category=$category_offers&sort=3$o_page$pages_offers\" title=\"$def_soft_new\"><img src=\"$def_mainlocation/images/sortA.gif\" border=\"0\"></a><a href=\"$def_mainlocation/alloffers.php?category=$category_offers&amp;sort=2$o_page$pages_offers\" title=\"$def_sort_all\"><img src=\"$def_mainlocation/images/sortZ.gif\" border=\"0\"></a>";

include ( "./template/$def_template/sort_offers_cat.php" ); // Подключаем шаблон сортировки

	if (isset($_GET['type'])) $_SESSION['type_offers_cat']=intval($_GET['type']);
        
        if ($_SESSION['type_offers_cat']!=0) {

            $o_sql=" AND $db_offers.type=$_SESSION[type_offers_cat]";
            if ($_SESSION[type_offers_cat]==1) $title_offers_cat.=' ('.$def_offer_1_s.')';
            if ($_SESSION[type_offers_cat]==2) $title_offers_cat.=' ('.$def_offer_2_s.')';
            if ($_SESSION[type_offers_cat]==3) $title_offers_cat.=' ('.$def_offer_3_s.')';


        }    else { $o_sql=""; unset ($_SESSION['type_offers_cat']); }


        if ((isset($_GET['sort'])) or (isset($_SESSION['sort_offers_cat'])))
	{

            if (isset($_GET['sort'])) $_SESSION['sort_offers_cat']=intval($_GET['sort']);

		switch ($_SESSION['sort_offers_cat']) {
			  case 1:
			    $o_sort=" ORDER BY $db_users.flag, $db_offers.item DESC";
			    break;
			  case 2:
			    $o_sort=" ORDER BY $db_users.flag, $db_offers.num";
			    break;
			  case 3:
			    $o_sort=" ORDER BY $db_users.flag, $db_offers.num DESC";
			    break;
			  case 4:
			    $o_sort=" ORDER BY $db_users.flag, $db_offers.price DESC";
			    break;
			  case 5:
			    $o_sort=" ORDER BY $db_users.flag, $db_offers.price";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY $db_users.flag, $db_offers.item";
		}
	}

	else $o_sort=" ORDER BY $db_users.flag, $db_offers.item";


main_table_top($title_offers_cat);

$main_cat=explode("#",$_SESSION['go_subcat_offer']);

if ($main_cat[0]!=$_GET['category']) unset($_SESSION['go_subcat_offer']);

if (empty($_SESSION['go_subcat_offer']) or ($_SESSION['go_subcat_offer']=="ALL")) {
    $like_sql1="$categorymains#%#%:%";
    $like_sql2="%:$categorymains#%#%:%";
    $like_sql3="%:$categorymains#%#%";
    $like_sql4="$categorymains#%#%";
} else
{
    $like_sql1=$_SESSION['go_subcat_offer'].':%';
    $like_sql2='%:'.$_SESSION['go_subcat_offer'].':%';
    $like_sql3='%:'.$_SESSION['go_subcat_offer'];
    $like_sql4=$_SESSION['go_subcat_offer'];
}

$r1 = $db->query ( "SELECT $db_offers.num, $db_offers.type, $db_offers.firmselector, $db_offers.item, $db_offers.date, $db_offers.message, $db_offers.quantity, $db_offers.packaging, $db_offers.price, $db_offers.period, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_offers  INNER JOIN $db_users ON $db_offers.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' $o_sql ");
@$result_in=mysql_num_rows ( $r1 );

$rz = $db->query ( "SELECT $db_offers.num, $db_offers.type, $db_offers.firmselector, $db_offers.item, $db_offers.date, $db_offers.message, $db_offers.quantity, $db_offers.packaging, $db_offers.price, $db_offers.period, $db_users.firmstate, $db_users.flag, $db_users.firmname, $db_users.category  FROM $db_offers  INNER JOIN $db_users ON $db_offers.firmselector = $db_users.selector WHERE ($db_users.category LIKE '$like_sql1' or $db_users.category LIKE '$like_sql2' or $db_users.category LIKE '$like_sql3' or $db_users.category LIKE '$like_sql4') and firmstate = 'on' $o_sql $o_sort LIMIT $page1, $def_count_srch" );
@$results_amount = mysql_num_rows ( $rz );


if ( $results_amount > 0 )

{

$last10_offers="NO";
	
include ("./includes/sub_component/catoffers.php");

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
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_offers.'-product'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/alloffers.php?category='.$category_offers.'"><b>'.$def_previous.'</b></a>&nbsp;';
            } else {
                if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$category_offers.'-product'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/alloffers.php?category='.$category_offers.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';
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
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_offers.'-product'.$def_rewrite_split.rewrite($f1['category']).'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/alloffers.php?category='.$category_offers.'"><b>'.($z+1).'</b></a>&nbsp;';
                    } else {
                        if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$category_offers.'-product'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.$z.'/"><b>'.($z+1).'</b></a>&nbsp;';
			else $page_news.= '<a href="'.$def_mainlocation.'/alloffers.php?category='.$category_offers.'&page='. $z.'"><b>'.($z+1).'</b></a>&nbsp;';
                    }
			$z++;
		}
	}

	if ($kPage - (($result_in / $def_count_srch) - 1) < 0) {
            if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$category_offers.'-product'.$def_rewrite_split.rewrite($f1['category']).$def_rewrite_split.'page'.$def_rewrite_split.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;';
            else $next_page = '<a href="'.$def_mainlocation.'/alloffers.php?category='.$category_offers.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';
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

echo '<div style="text-align: left; padding: 0 5px">'.$def_offers_sum.' - <b>'.$result_in.'</b></div>';

}

else {

    $def_title_error = $def_warning_msg;
    $def_message_error = $def_not_error;

    include ( "./includes/error_page.php" );

}

main_table_bottom();

}

}

$db->freeresult ( $fz );

include ( "./template/$def_template/footer.php" );

}

?>