<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: sitemap.php
-----------------------------------------------------
 Назначение: Карта сайта
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$sitemap_help;

$title_cp = 'Карта сайта - ';
$speedbar = ' | <a href="sitemap.php">Карта сайта Sitemap</a>';

check_login_cp('0_0','sitemap.php');

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/sitemap.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Карта сайта</span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34"></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>            
                <td width="450" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" /><a href="sitemap.php?ping=new">Уведомить поисковые системы о наличии новой версии карты сайта</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

// Пингуем
if ($_GET['ping']=='new') {

    $otvet='';

    echo '<div align="center"><div style="width:500px;" class="alert alert-info"><br />Подождите идет подключение к удаленному серверу ...';

    $map_link = $def_mainlocation.'/sitemaps/sitemap.xml';

    function send_url($url, $map) {

	$data = false;

	$file = $url.urlencode($map);

	if( (function_exists( 'curl_init' ) and function_exists('curl_setopt')) ) {

		@ $ch = curl_init();
		@ curl_setopt( $ch, CURLOPT_URL, $file );
		@ curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		@ curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		@ curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		@ curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 6 );

		@ $data = curl_exec( $ch );
		@ curl_close( $ch );

		return $data;

	} else {

		return @file_get_contents( $file );

	}

}


if (strpos ( send_url("http://google.com/webmasters/sitemaps/ping?sitemap=", $map_link), "successfully added" ) !== false) {

	$otvet .= "<br />Уведомление поисковой системы  Google: <font color=\"green\">отправка завершена</font>";

} else {

	$otvet .= "<br />Уведомление поисковой системы  Google: <font color=\"red\">ошибка отправки</font> URL: <a href=\"http://google.com/webmasters/sitemaps/ping?sitemap=".urlencode($map_link)."\" target=\"_blank\">http://google.com/webmasters/sitemaps/ping?sitemap=$map_link</a>";

}

if (strpos ( send_url("http://ping.blogs.yandex.ru/ping?sitemap=", $map_link), "OK" ) !== false) {

	$otvet .= "<br />Уведомление поисковой системы  Yandex: <font color=\"green\">отправка завершена</font>";

} else {

	$otvet .= "<br />Уведомление поисковой системы  Yandex: <font color=\"red\">ошибка отправки</font> URL: <a href=\"http://ping.blogs.yandex.ru/ping?sitemap=".urlencode($map_link)."\" target=\"_blank\">http://ping.blogs.yandex.ru/ping?sitemap=$map_link</a>";

}

$otvet .= "<br /><br /><b>Отправить по HTTP</b>:<br />Google: <a href=\"http://www.google.ru/webmasters/tools/ping?sitemap=".urlencode($map_link)."\" target=\"_blank\">www.google.ru/webmasters/tools/ping?sitemap=$map_link</a><br />Yandex: <a href=\"http://webmaster.yandex.ru/site/map.xml?host=".urlencode($map_link)."\" target=\"_blank\">webmaster.yandex.ru/site/map.xml?host=$map_link</a> ";

    echo $otvet.'</div></div>';

}

require 'inc/function_sitemap.php';

unset ($_SESSION['link_map']);

// Создаем карту категорий
if ($_POST['category']=='category') {

    $map_all='';
    $map_cat='';
    $map_subcat='';
    $map_subsubcat='';
    $map_cat_offers='';
    $map_cat_xls='';
    $map_cat_gallery='';
    $map_cat_web='';
    $map_cat_info1='';
    $map_cat_info2='';
    $map_cat_info3='';
    $map_cat_info4='';
    $map_cat_info5='';
    $array_cat_name=array();
    $array_subcat_name=array();
    $lastmod = date( "Y-m-d" );

    $file_name='sitemap_category.xml';

    // Создаем основные категории
    if ($_POST['cat_users']==1) {
     
         // Категории
         $r = $db->query ( "SELECT selector, category, fcounter FROM $db_category WHERE fcounter>0 ORDER BY category" );
         $res = $db->numrows ( $r );
            for ( $i=0;$i<$res;$i++ ) {
                $f = $db->fetcharray ( $r );
                    if ($def_rewrite == "YES") $loc = $def_mainlocation . '/' . rewrite($f['category']) . '/' . $f['selector'] . '-0.html';
                    else $loc = $def_mainlocation . '/index.php?category=' . $f['selector'];
                    $map_cat .= xml_get($loc,$lastmod,'1');
                    $array_cat_name[$f['selector']]=$f['category'];         
            }

         // Подкатегории
         $r_subcat = $db->query ( "SELECT catsel, catsubsel, subcategory, fcounter FROM $db_subcategory WHERE fcounter>0 ORDER BY subcategory" );
         $res_subcat = $db->numrows ( $r_subcat );
            for ( $j=0;$j<$res_subcat;$j++ ) {
                $f_sub = $db->fetcharray ( $r_subcat );
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/'. rewrite($array_cat_name[$f_sub['catsel']]) .'/'. rewrite($f_sub['subcategory']).'/'.$f_sub['catsel'].'-'.$f_sub['catsubsel'].'-0.html';
		else $loc = $def_mainlocation.'/index.php?cat='.$f_sub['catsel'].'&subcat='.$f_sub['catsubsel'];
                $map_subcat .= xml_get($loc,$lastmod,'1');
                $array_subcat_name[$f_sub['catsubsel']]=$f_sub['subcategory'];
            }

         // Разделы подкатегорий
         $r_subsubcat = $db->query ( "SELECT * FROM $db_subsubcategory WHERE fcounter>0 ORDER BY subsubcategory" );
         $res_subsubcat = $db->numrows ( $r_subsubcat );
            for ( $k=0;$k<$res_subsubcat;$k++ ) {
                $f_subsub = $db->fetcharray ( $r_subsubcat );
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/'.rewrite($array_cat_name[$f_subsub['catsel']]).'/'.rewrite($array_subcat_name[$f_subsub['catsubsel']]).'/'.str_replace(' ', '_', rewrite($f_subsub['subsubcategory'])).'/'.$f_subsub['catsel'].'-'.$f_subsub['catsubsel'].'-'.$f_subsub['catsubsubsel'].'-0.html';
		else $loc = $def_mainlocation.'/index.php?cat='.$f_subsub['catsel'].'&subcat='.$f_subsub['catsubsel'].'&subsubcat='.$f_subsub['catsubsubsel'];
                $map_subsubcat .= xml_get($loc,$lastmod,'1');
            }

    }

   // Контент
    
         $r_cont = $db->query ( "SELECT category, selector FROM $db_category WHERE fcounter>0 ORDER BY category" );
         $res_cont = $db->numrows ( $r_cont );
         for ( $o=0;$o<$res_cont;$o++ ) {
             $f_cont = $db->fetcharray ( $r_cont );
                    if ($_POST['cat_offers']==1) {
                        if ($def_rewrite == "YES") {

                        if ($o==0) $map_cat_gallery .= xml_get($def_mainlocation.'/product/',$lastmod,'1');
                        $loc = $def_mainlocation.'/'.$f_cont['selector'].'-product'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                        $map_cat_gallery .= xml_get($loc,$lastmod,'1');

                        } else {

                        if ($o==0) $map_cat_offers .= xml_get($def_mainlocation.'/alloffers.php',$lastmod,'1');
                        $loc=dubl_cat('alloffers', $f_cont['selector'], 0);
                        $map_cat_offers .= xml_get($loc,$lastmod,'1');
                        
                        }
                    }
                    if ($_POST['cat_xls']==1) {

                         if ($def_rewrite == "YES") {

                        if ($o==0) $map_cat_gallery .= xml_get($def_mainlocation.'/price/',$lastmod,'1');
                        $loc = $def_mainlocation.'/'.$f_cont['selector'].'-price'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                        $map_cat_gallery .= xml_get($loc,$lastmod,'1');

                        } else {

                        if ($o==0) $map_cat_xls .= xml_get($def_mainlocation.'/allxls.php',$lastmod,'1');
                        $loc=dubl_cat('allxls', $f_cont['selector'], 0);
                        $map_cat_xls .= xml_get($loc,$lastmod,'1');

                        }
                    }
                    if ($_POST['cat_gallery']==1) {
                        if ($def_rewrite == "YES") {

                        if ($o==0) $map_cat_gallery .= xml_get($def_mainlocation.'/gallery/',$lastmod,'1');
                        $loc = $def_mainlocation.'/'.$f_cont['selector'].'-gallery'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                        $map_cat_gallery .= xml_get($loc,$lastmod,'1');

                        } else {

                        if ($o==0) $map_cat_gallery .= xml_get($def_mainlocation.'/allimg.php',$lastmod,'1');
                        $loc=dubl_cat('allimg', $f_cont['selector'], 0);
                        $map_cat_gallery .= xml_get($loc,$lastmod,'1');

                        }
                    }
                    if ($_POST['cat_web']==1) {
                        if ($def_rewrite == "YES") {

                        if ($o==0) $map_cat_web .= xml_get($def_mainlocation.'/site/',$lastmod,'1');
                        $loc = $def_mainlocation.'/'.$f_cont['selector'].'-site'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                        $map_cat_web .= xml_get($loc,$lastmod,'1');

                        } else {

                        if ($o==0) $map_cat_web .= xml_get($def_mainlocation.'/allweb.php',$lastmod,'1');
                        $loc=dubl_cat('allweb', $f_cont['selector'], 0);
                        $map_cat_web .= xml_get($loc,$lastmod,'1');

                        }
                    }
                    if ($_POST['cat_pub']==1) {
                        
                        if ($def_rewrite == "YES") {

                            if ($o==0) $map_cat_info1 .= xml_get($def_mainlocation.'/inews/',$lastmod,'1');
                            $loc = $def_mainlocation.'/'.$f_cont['selector'].'-inews'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                            $map_cat_info1 .= xml_get($loc,$lastmod,'1');

                        } else {
                        
                            if ($o==0) $map_cat_info1 .= xml_get($def_mainlocation.'/allinfo.php?type=1',$lastmod,'1');
                            $loc=dubl_cat('allinfo', $f_cont['selector'], 1);
                            $map_cat_info1 .= xml_get($loc,$lastmod,'1');
                        
                        }
                        
                        if ($def_rewrite == "YES") {

                            if ($o==0) $map_cat_info2 .= xml_get($def_mainlocation.'/itender/',$lastmod,'1');
                            $loc = $def_mainlocation.'/'.$f_cont['selector'].'-itender'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                            $map_cat_info2 .= xml_get($loc,$lastmod,'1');

                        } else {
                        
                            if ($o==0) $map_cat_info2 .= xml_get($def_mainlocation.'/allinfo.php?type=2',$lastmod,'1');
                            $loc=dubl_cat('allinfo', $f_cont['selector'], 2);
                            $map_cat_info2 .= xml_get($loc,$lastmod,'1');
                        
                        }
                        
                        if ($def_rewrite == "YES") {

                            if ($o==0) $map_cat_info3 .= xml_get($def_mainlocation.'/iboard/',$lastmod,'1');
                            $loc = $def_mainlocation.'/'.$f_cont['selector'].'-iboard'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                            $map_cat_info3 .= xml_get($loc,$lastmod,'1');

                        } else {                        
                        
                            if ($o==0) $map_cat_info3 .= xml_get($def_mainlocation.'/allinfo.php?type=3',$lastmod,'1');
                            $loc=dubl_cat('allinfo', $f_cont['selector'], 3);
                            $map_cat_info3 .= xml_get($loc,$lastmod,'1');
                        
                        }
                        
                        if ($def_rewrite == "YES") {

                            if ($o==0) $map_cat_info4 .= xml_get($def_mainlocation.'/ijob/',$lastmod,'1');
                            $loc = $def_mainlocation.'/'.$f_cont['selector'].'-ijob'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                            $map_cat_info4 .= xml_get($loc,$lastmod,'1');

                        } else {                        
                        
                            if ($o==0) $map_cat_info4 .= xml_get($def_mainlocation.'/allinfo.php?type=4',$lastmod,'1');
                            $loc=dubl_cat('allinfo', $f_cont['selector'], 4);
                            $map_cat_info4 .= xml_get($loc,$lastmod,'1');
                        
                        }
                        
                        if ($def_rewrite == "YES") {

                            if ($o==0) $map_cat_info5 .= xml_get($def_mainlocation.'/ipressrel/',$lastmod,'1');
                            $loc = $def_mainlocation.'/'.$f_cont['selector'].'-ipressrel'.$def_rewrite_split.rewrite($f_cont['category']) . '/';
                            $map_cat_info5 .= xml_get($loc,$lastmod,'1');

                        } else {                           
                        
                            if ($o==0) $map_cat_info5 .= xml_get($def_mainlocation.'/allinfo.php?type=5',$lastmod,'1');
                            $loc=dubl_cat('allinfo', $f_cont['selector'], 5);
                            $map_cat_info5 .= xml_get($loc,$lastmod,'1');
                        
                        }
                    }
         }

// Создаем файл карты категорий

    $map_all = $map_cat;
    $map_all .= $map_subcat;
    $map_all .= $map_subsubcat;
    $map_all .= $map_cat_offers;
    $map_all .= $map_cat_xls;
    $map_all .= $map_cat_gallery;
    $map_all .= $map_cat_web;
    $map_all .= $map_cat_info1;
    $map_all .= $map_cat_info2;
    $map_all .= $map_cat_info3;
    $map_all .= $map_cat_info4;
    $map_all .= $map_cat_info5;

    
    if ($map_all!='') {

        $map_all = url_sitempap($map_all);

        fopen_map($map_all,$file_name);
        
        index_sitemap(); // Обновляем индексный файл

        msg_text('80%',$def_admin_message_ok, 'Карта категорий успешно создана. Файл карты <b>sitemaps/sitemap_category.xml</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');
    }
    
    else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');

}

// Создаем карту фирм
if ($_POST['firm']=='firm') {

    $map_all='';
    $map_users='';
    $lastmod = date( "Y-m-d" );
    $array_cat_name=array();
    $array_subcat_name=array();
    $array_subsubcat_name=array();

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_users_'.$file_name.'.xml'; else $file_name='sitemap_users.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" and (selector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" and selector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" and selector < $id_do ";

    $r = $db->query ( "SELECT selector, category FROM $db_users WHERE firmstate='on' $where_sql" );
    $res_users = $db->numrows ( $r );
    
    if ($res_users>0) {

         // Заносим в массив имена категорий и их разделов
         // Категории
         $r_cat = $db->query ( "SELECT selector, category FROM $db_category WHERE fcounter>0 ORDER BY category" );
         $res = $db->numrows ( $r );
            for ( $i=0;$i<$res;$i++ ) {
                $f_cat = $db->fetcharray ( $r_cat );
                    $array_cat_name[$f_cat['selector']]=$f_cat['category'];
            }

         // Подкатегории
         $r_subcat = $db->query ( "SELECT catsubsel, subcategory FROM $db_subcategory WHERE fcounter>0 ORDER BY subcategory" );
         $res_subcat = $db->numrows ( $r_subcat );
            for ( $j=0;$j<$res_subcat;$j++ ) {
                $f_sub = $db->fetcharray ( $r_subcat );
                $array_subcat_name[$f_sub['catsubsel']]=$f_sub['subcategory'];
            }

         // Разделы подкатегорий
         $r_subsubcat = $db->query ( "SELECT catsubsubsel, subsubcategory  FROM $db_subsubcategory WHERE fcounter>0 ORDER BY subsubcategory" );
         $res_subsubcat = $db->numrows ( $r_subsubcat );
            for ( $k=0;$k<$res_subsubcat;$k++ ) {
                $f_subsub = $db->fetcharray ( $r_subsubcat );
                $array_subsubcat_name[$f_subsub['catsubsubsel']]=$f_subsub['subsubcategory'];
            }

         // Формируем ссылки фирм
         for ( $p=0;$p<$res_users;$p++ ) {
             $f_users = $db->fetcharray ( $r );

             	$maincatx = explode (":", $f_users['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];

                    if (($getcat != 0) and ($getsubcat == 0) and ($getsubsubcat == 0))
                    {
                        if ($def_rewrite == "YES")
                        $loc = $def_mainlocation .'/' . rewrite($array_cat_name[$getcat]) . '/' . $getcat . "-0-0-" . $f_users['selector'] . '-0-0.html';
                        else
                        $loc = $def_mainlocation ."/view.php?id=" . $f_users['selector'] . "&cat=" . $getcat . "&subcat=" . $getsubcat . "&subsubcat=" . $getsubsubcat;
                    }

                    if (($getsubcat != 0) and ($getsubsubcat == 0))
                    {
                        if ($def_rewrite == "YES")
                        $loc = $def_mainlocation .'/' . rewrite($array_cat_name[$getcat]) . '/' . rewrite($array_subcat_name[$getsubcat]) . '/' . $getcat . '-' . $getsubcat . '-0-' . $f_users['selector'] . '-0-0.html';
                        else
                        $loc =  $def_mainlocation .'/view.php?id=' . $f_users['selector'] . "&cat=" . $getcat . "&subcat=" . $getsubcat . "&subsubcat=" . $getsubsubcat;
                    }

                    if ($getsubsubcat != 0)
                    {
                        if ($def_rewrite == "YES")
                        $loc = $def_mainlocation ."/" . rewrite($array_cat_name[$getcat]) . '/' . rewrite($array_subcat_name[$getsubcat]) . '/' . rewrite($array_subsubcat_name[$getsubsubcat]) . '/' . $getcat . '-' . $getsubcat . '-' . $getsubsubcat . '-' . $f_users['selector'] . '-0-0.html';
                        else
                        $loc = $def_mainlocation .'/view.php?id=' . $f_users['selector'] . '&cat=' . $getcat . '&subcat=' . $getsubcat . '&subsubcat=' . $getsubsubcat;
                    }

                    $map_users .= xml_get($loc,$lastmod,'1');
         }

    }
    
        $map_all = $map_users;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта фирм успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');
        
        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');

}

// Создаем карту контента
if ($_POST['content']=='content') {

    $map_all='';
    $map_cat_offers='';
    $map_cat_xls='';
    $map_cat_gallery='';
    $map_cat_video='';
    $map_cat_filial='';
    $map_cat_info1='';
    $map_cat_info2='';
    $map_cat_info3='';
    $map_cat_info4='';
    $map_cat_info5='';
    $map_cat_reviews='';
    $lastmod = date( "Y-m-d" );

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_content_'.$file_name.'.xml'; else $file_name='sitemap_content.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" and (firmselector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" and firmselector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" and firmselector < $id_do ";

// Карта товаров и услуг фирм
if ($_POST['cat_offers']==1) {

    $r_offers = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_offers AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_offers = $db->numrows ( $r_offers );

     for ( $p=0;$p<$res_offers;$p++ ) {
             $f_offers = $db->fetcharray ( $r_offers );

             	$maincatx = explode (":", $f_offers['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/offers-'.$f_offers['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'-all.html';
		else $loc = $def_mainlocation.'/offers.php?id='.$f_offers['firmselector'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat.'&type=all';

                $map_cat_offers .= xml_get($loc,$lastmod,'1');
     }
}

// Карта галереи изображений
if ($_POST['cat_gallery']==1) {

    $r_gallery = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_images AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_gallery = $db->numrows ( $r_gallery );

     for ( $p=0;$p<$res_gallery;$p++ ) {
             $f_gallery = $db->fetcharray ( $r_gallery );

             	$maincatx = explode (":", $f_gallery['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/gallery-'.$f_gallery['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/gallery.php?id='.$f_gallery['firmselector'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_gallery .= xml_get($loc,$lastmod,'1');
     }
}

// Карта прайс-листов
if ($_POST['cat_xls']==1) {

    $r_xls = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_exelp AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_xls = $db->numrows ( $r_xls );

     for ( $p=0;$p<$res_xls;$p++ ) {
             $f_xls = $db->fetcharray ( $r_xls );

             	$maincatx = explode (":", $f_xls['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/excel-'.$f_xls['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/exel.php?id='.$f_xls['firmselector'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_xls .= xml_get($loc,$lastmod,'0.9');
     }
}

// Карта видеороликов
if ($_POST['cat_video']==1) {

    $r_video = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_video AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_video = $db->numrows ( $r_video );

     for ( $p=0;$p<$res_video;$p++ ) {
             $f_video = $db->fetcharray ( $r_video );

             	$maincatx = explode (":", $f_video['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/video-'.$f_video['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/video.php?id='.$f_video['firmselector'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_video .= xml_get($loc,$lastmod,'0.5');
     }
}

// Карта филиалов
if ($_POST['cat_filial']==1) {

    $r_filial = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_filial AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql GROUP BY r.firmselector ORDER BY r.num DESC ");
    $res_filial = $db->numrows ( $r_filial );

     for ( $p=0;$p<$res_filial;$p++ ) {
             $f_filial = $db->fetcharray ( $r_filial );

             	$maincatx = explode (":", $f_filial['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/filial-'.$f_filial['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/filial.php?id='.$f_filial['firmselector'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_filial .= xml_get($loc,$lastmod,'0.9');
     }
}

// Публикации компаний

if ($_POST['cat_pub']==1) {

    // Новости
    $r_info1 = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_info AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' and type = '1' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_info1 = $db->numrows ( $r_info1 );

     for ( $p=0;$p<$res_info1;$p++ ) {
             $f_info1 = $db->fetcharray ( $r_info1 );

             	$maincatx = explode (":", $f_info1['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/news-'.$f_info1['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/publication.php?id='.$f_info1['firmselector'].'&type=1&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info1 .= xml_get($loc,$lastmod,'1');
     }

    // Тендеры
    $r_info2 = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_info AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' and type = '2' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_info2 = $db->numrows ( $r_info2 );

     for ( $p=0;$p<$res_info2;$p++ ) {
             $f_info2 = $db->fetcharray ( $r_info2 );

             	$maincatx = explode (":", $f_info2['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/tender-'.$f_info2['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/publication.php?id='.$f_info2['firmselector'].'&type=2&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info2 .= xml_get($loc,$lastmod,'1');
     }

    // Объявления
    $r_info3 = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_info AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' and type = '3' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_info3 = $db->numrows ( $r_info3 );

     for ( $p=0;$p<$res_info3;$p++ ) {
             $f_info3 = $db->fetcharray ( $r_info3 );

             	$maincatx = explode (":", $f_info3['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/board-'.$f_info3['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/publication.php?id='.$f_info3['firmselector'].'&type=3&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info3 .= xml_get($loc,$lastmod,'1');
     }

    // Вакансии
    $r_info4 = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_info AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' and type = '4' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_info4 = $db->numrows ( $r_info4 );

     for ( $p=0;$p<$res_info4;$p++ ) {
             $f_info4 = $db->fetcharray ( $r_info4 );

             	$maincatx = explode (":", $f_info4['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/job-'.$f_info4['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/publication.php?id='.$f_info4['firmselector'].'&type=4&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info4 .= xml_get($loc,$lastmod,'1');
     }

    // Пресс-релизы
    $r_info5 = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_info AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' and type = '5' $where_sql GROUP BY r.firmselector ORDER BY r.date ");
    $res_info5 = $db->numrows ( $r_info5 );

     for ( $p=0;$p<$res_info5;$p++ ) {
             $f_info5 = $db->fetcharray ( $r_info5 );

             	$maincatx = explode (":", $f_info5['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/pressrel-'.$f_info5['firmselector'].'-0-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $loc = $def_mainlocation.'/publication.php?id='.$f_info5['firmselector'].'&type=5&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info5 .= xml_get($loc,$lastmod,'1');
     }

}

// Карта отзывов (комментариев)
if ($_POST['cat_reviews']==1) {

    $where_sqlr="";
    if (($id_ot>0) and ($id_do>0)) $where_sqlr=" and (company between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sqlr=" and company > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sqlr=" and company < $id_do ";

    $r_reviews = $db->query ( "SELECT r.id, r.company, f.category  FROM $db_reviews AS r  INNER JOIN $db_users AS f ON r.company = f.selector WHERE status = 'on' $where_sqlr GROUP BY r.company ORDER BY r.id DESC ");
    $res_reviews = $db->numrows ( $r_reviews );

     for ( $p=0;$p<$res_reviews;$p++ ) {
             $f_reviews = $db->fetcharray ( $r_reviews );

             	$maincatx = explode (":", $f_reviews['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                if ($def_rewrite == "YES") $loc = $def_mainlocation.'/view-reviews-'.$f_reviews['company'].'-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'-0.html';
		else $loc = $def_mainlocation.'/reviews.php?id='.$f_reviews['company'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_reviews .= xml_get($loc,$lastmod,'1');
     }
}


// Формируем карту контента в файл

    $map_all .= $map_cat_offers;
    $map_all .= $map_cat_xls;
    $map_all .= $map_cat_gallery;
    $map_all .= $map_cat_video;
    $map_all .= $map_cat_filial;
    $map_all .= $map_cat_info1;
    $map_all .= $map_cat_info2;
    $map_all .= $map_cat_info3;
    $map_all .= $map_cat_info4;
    $map_all .= $map_cat_info5;
    $map_all .= $map_cat_reviews;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта контента успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');

        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');

}

// Создаем карту продукции и услуг
if ($_POST['offers']=='offers') {

    $map_all='';
    $map_cat_offers='';

    $lastmod = date( "Y-m-d" );

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_offers_'.$file_name.'.xml'; else $file_name='sitemap_offers.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" and (firmselector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" and firmselector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" and firmselector < $id_do ";

    $r_offers = $db->query ( "SELECT r.num, r.firmselector, f.category  FROM $db_offers AS r  INNER JOIN $db_users AS f ON r.firmselector = f.selector WHERE firmstate = 'on' $where_sql ORDER BY r.date ");
    $res_offers = $db->numrows ( $r_offers );

     for ( $p=0;$p<$res_offers;$p++ ) {
             $f_offers = $db->fetcharray ( $r_offers );

             	$maincatx = explode (":", $f_offers['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                $loc = $def_mainlocation.'/alloffers.php?idfull='.$f_offers['firmselector'].'&full='.$f_offers['num'].'&catfirm='.$getcat;

                $map_cat_offers .= xml_get($loc,$lastmod,'1');
     }

// Формируем карту продукции и услуг в файл

    $map_all .= $map_cat_offers;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта продукции и услуг успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');

        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');
}

// Создаем карту публикаций
if ($_POST['info']=='info') {

    $map_all='';
    $map_cat_info='';

    $lastmod = date( "Y-m-d" );

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_info_'.$file_name.'.xml'; else $file_name='sitemap_info.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" WHERE and (firmselector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" WHERE and firmselector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" WHERE and firmselector < $id_do ";

    $r_info = $db->query ( "SELECT category, num, type FROM $db_info $where_sql ORDER BY date ");
    $res_info = $db->numrows ( $r_info );

     for ( $p=0;$p<$res_info;$p++ ) {
             $f_info = $db->fetcharray ( $r_info );

             	$maincatx = explode (":", $f_info['category']);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
                
                if ($def_rewrite == "YES") {
                    
                    if ($f_info['type']==1) $n_type="news";
                    if ($f_info['type']==2) $n_type="tender";
                    if ($f_info['type']==3) $n_type="board";
                    if ($f_info['type']==4) $n_type="job";
                    if ($f_info['type']==5) $n_type="pressrel";
                    
                    $loc = $def_mainlocation.'/'.$n_type.'-'.$f_info['num'].'-'.$getcat.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
                    
                } else $loc = $def_mainlocation.'/viewinfo.php?vi='.$f_info['num'].'&cat='.$getcat.'&subcat='.$getsubcat.'&subsubcat='.$getsubsubcat;

                $map_cat_info .= xml_get($loc,$lastmod,'1');
     }

// Формируем карту публикаций в файл

    $map_all .= $map_cat_info;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта публикаций успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');

        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');
}

// Создаем карту новостей
if ($_POST['news']=='news') {

    $map_all='';
    $map_cat_news='';
    $map_news='';

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_news_'.$file_name.'.xml'; else $file_name='sitemap_news.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" WHERE and (selector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" WHERE and selector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" WHERE and selector < $id_do ";

    // Карта категорий новостей
    $r_catnews = $db->query ( "SELECT selector, name FROM $db_categorynews ORDER BY category " );
    $res_catnews = $db->numrows ( $r_catnews );

    for ( $p=0;$p<$res_catnews;$p++ ) {
             $f_catnews = $db->fetcharray ( $r_catnews );

        if ($def_rewrite_news == "YES") $loc = $def_mainlocation.'/news/'.$f_catnews['name'].'/';
        else $loc = $def_mainlocation.'/allnews.php?category='.$f_catnews['selector'];
        $array_cat_name[$f_catnews['selector']]=$f_catnews['name'];
        $lastmod = date( "Y-m-d" );

        $map_cat_news .= xml_get($loc,$lastmod,'1');
    }


    $r_news = $db->query ( "SELECT selector, name, category, date FROM $db_news WHERE status_off = 0 $where_sql ORDER BY date");
    $res_news = $db->numrows ( $r_news );

     for ( $p=0;$p<$res_news;$p++ ) {
             $f_news = $db->fetcharray ( $r_news );

                if ($def_rewrite_news == "YES") $loc=$def_mainlocation.'/news/'.$array_cat_name[$f_news['category']].'/'.$f_news['selector'].'-'.$f_news['name'].'.html';
                else $loc = $def_mainlocation.'/news.php?id='.$f_news['selector'].'&cat='.$f_news['category'];
                $lastmod = date( "Y-m-d", strtotime($f_news['date']) );
                $map_news .= xml_get($loc,$lastmod,'1');
     }

// Формируем карту публикаций в файл

    $map_all .= $map_cat_news;
    $map_all .= $map_news;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта публикаций успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');

        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');
}

// Создаем карту статических страниц
if ($_POST['static']=='static') {

    $map_all='';
    $map_static='';

    $file_name=htmlspecialchars(strip_tags(trim($_POST['file_name'])));
    if ($file_name!='') $file_name='sitemap_static_'.$file_name.'.xml'; else $file_name='sitemap_static.xml';

    $id_ot=intval($_POST['id_ot']);
    $id_do=intval($_POST['id_do']);

    $where_sql="";
    if (($id_ot>0) and ($id_do>0)) $where_sql=" WHERE and (selector between $id_ot and $id_do ) ";
    if (($id_ot>0) and ($id_do==0)) $where_sql=" WHERE and selector > $id_ot ";
    if (($id_ot==0) and ($id_do>0)) $where_sql=" WHERE and selector < $id_do ";


    $r_static = $db->query ( "SELECT selector, name, date FROM $db_static WHERE noindex <> 1 $where_sql ORDER BY date");
    $res_static = $db->numrows ( $r_static );

     for ( $p=0;$p<$res_static;$p++ ) {
             $f_static = $db->fetcharray ( $r_static );

                if ($def_rewrite_news == "YES") $loc=$def_mainlocation.'/'.$f_static['name'].'.html';
                else $loc = $def_mainlocation.'/viewstatic.php?vs='.$f_static['name'];
                $lastmod = date( "Y-m-d", strtotime($f_static['date']) );
                $map_static .= xml_get($loc,$lastmod,'1');
     }

// Формируем карту публикаций в файл

    $map_all .= $map_static;

        if ($map_all!='') {

            $map_all = url_sitempap($map_all);

            fopen_map($map_all,$file_name);

            index_sitemap(); // Обновляем индексный файл

            msg_text('80%',$def_admin_message_ok, 'Карта статических страниц успешно создана. Файл карты <b>sitemaps/'.$file_name.'</b><br>Создано ссылок: <b>'.$_SESSION['link_map'].'</b>');

        } else msg_text('80%',$def_admin_message_error, 'Ошибка выполнения заданной команды. Данные отсутствуют.');
}

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
	border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
	height: 25px;
	padding-top: 2px;
	padding-left: 5px;
	text-align: center;
	border: 1px solid #A6B2D5;
        }
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>


<table width="800" border="0" cellspacing="0" cellpadding="0" class="main_list" align="center">
  <tr>
    <th>Название карты</th>
    <th>Файл</th>
    <th>Параметры
    <th>Команда</th>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта категорий</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_category.xml</span></td>
    <td><input name="cat_users" type="checkbox" value="1" checked> Категории фирм<br />
      <input name="cat_offers" type="checkbox" value="1" checked> Категории продукции и услуг<br />
      <input name="cat_pub" type="checkbox" value="1" checked> Категории публикаций<br />
      <input name="cat_xls" type="checkbox" value="1" checked> Категории прайс-листов<br />
      <input name="cat_gallery" type="checkbox" value="1" checked> Категории изображений<br />
      <input name="cat_web" type="checkbox" value="1" checked> Категории сайтов организаций
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="category" value="category" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта фирм</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_users_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
id фирм от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" />
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="firm" value="firm" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта контента фирм</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_content_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
      id фирм от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" /><br />
      <input name="cat_offers" type="checkbox" value="1" checked> <? echo $def_admin_offers; ?><br />
      <input name="cat_pub" type="checkbox" value="1" checked><? echo $def_info_infos; ?><br />
      <input name="cat_xls" type="checkbox" value="1" checked><? echo $def_admin_exel; ?><br />
      <input name="cat_gallery" type="checkbox" value="1" checked> <? echo $def_admin_images ?><br />
      <input name="cat_video" type="checkbox" value="1" checked> <? echo $def_admin_video; ?><br />
      <input name="cat_filial" type="checkbox" value="1" checked> <? echo $def_info_filial; ?><br />
      <input name="cat_reviews" type="checkbox" value="1" checked> Комментарии
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="content" value="content" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта продукции и услуг</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_offers_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
      id фирм от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" /><br />
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="offers" value="offers" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта публикаций фирм</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_info_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
      id фирм от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" /><br />
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="info" value="info" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта новостей</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_news_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
      id новости от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" /><br />
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="news" value="news" /></td>
    </form>
  </tr>
  <tr>
    <td colspan="4" align="center"><hr /></td>
  </tr>
  <tr>
    <form name="category" method="post" action="sitemap.php">
    <td align="center"><b>Карта статических страниц</b></td>
    <td align="center"><span style="color: #FF0000">sitemaps/sitemap_static_<input type="text" name="file_name" style="width: 40px;" />.xml</span></td>
    <td>
      id страниц от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" /><br />
    </td>
    <td align="center"><input type="submit" name="button" value="Создать карту" /><input type="hidden" name="static" value="static" /></td>
    </form>
  </tr>
</table>

<?

require_once 'template/footer.php';

?>