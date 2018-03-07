<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: sub.php
-----------------------------------------------------
 Назначение: Краткая версия информации о компании
=====================================================
*/

if (!isset($fetchcounter) ) $fetchcounter = 1;

echo "<br>
         <table cellspacing=\"1\" cellpadding=\"5\" border=\"0\" width=\"97%\">
          ";

$template_sub_a = implode ('', file('./template/' . $def_template . '/sub_a.tpl'));
$template_sub_b = implode ('', file('./template/' . $def_template . '/sub_b.tpl'));
$template_sub_c = implode ('', file('./template/' . $def_template . '/sub_c.tpl'));
$template_sub_d = implode ('', file('./template/' . $def_template . '/sub_d.tpl'));

for ( $iii=0; $iii<$fetchcounter; $iii++ )

{

	$f = $db->fetcharray  ( $r );
	$id = intval($f['selector']);

// Определяем подключение социальной странички к каталогу

        // Продукция и услуги

	if ((ifEnabled($f[flag], "products")) and ($def_allow_products == "YES"))
	{
            $offers_r = $db->query  ( "SELECT num FROM $db_offers where firmselector = '$f[selector]'" );
            $r_offers=mysql_num_rows($offers_r);
            if ( $r_offers > 0 ) $offers_link = $def_offers_mark;
            else $offers_link="";
	} else $offers_link="";

	// Галерея изображений

	if ((ifEnabled($f[flag], "images")) and ($def_allow_images == "YES"))
	{
            $images_r = $db->query  ( "SELECT num FROM $db_images where firmselector = '$f[selector]'" );
            $r_images=mysql_num_rows($images_r);
            if ( $r_images > 0 ) $images_link = $def_images_mark;
            else $images_link="";
	} else $images_link="";

        $social_page=$r_offers+$r_images;

// -----------------------------------------------------------------

	if ($f[flag] == "A") $template_sub = $template_sub_a;
	if ($f[flag] == "B") $template_sub = $template_sub_b;
	if ($f[flag] == "C") $template_sub = $template_sub_c;
	if ($f[flag] == "D") $template_sub = $template_sub_d;

	if ( $iii%2 == 0 ) $color = $def_form_back_color; else $color = $def_background;
        
	$template = new Template;

	$template->load($template_sub);

        $getcat = intval($_GET['cat']);
	$getcategory = intval($_GET['category']);
	$getsubcat = intval($_GET['subcat']);
	$getsubsubcat = intval($_GET['subsubcat']);

	if ( (empty($getcat)) and (empty($getcategory)) )

	{
		$maincatx = explode (":", $f[category]);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getcategory = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];
	}

// Формируем ссылку на компанию
if (($f['theme']!='') and ($f['domen']!='') and (ifEnabled($f[flag], "social"))) { $template->replace("link", $def_mainlocation ."/".$f['domen']); }
else {
        
	$category = 0; $maincategory = "";
	$subcategory = 0; $mainsubcategory = "";
	$subsubcategory = 0; $mainsubsubcategory = "";

	$r_cat = mysql_query ( "SELECT selector, category FROM $db_category WHERE selector='$getcat' or selector='$getcategory'" );
	$f_cat = mysql_fetch_array ( $r_cat );
	$category = $f_cat['selector'];
	$maincategory = $f_cat['category'];
	$db->freeresult($r_cat);

	if ( ($getsubcat != "0") and (isset($getsubcat)) )

	{
		$r_cat = mysql_query ( "SELECT catsubsel, subcategory FROM $db_subcategory WHERE ( (catsel='$getcat' or catsel='$getcategory') and (catsubsel = '$getsubcat') )" );
		$f_cat = mysql_fetch_array ( $r_cat );
		$subcategory = $f_cat['catsubsel'];
		$mainsubcategory = $f_cat['subcategory'];
		$db->freeresult($r_cat);
	}

	if ( ( ($getsubcat != "0") and (isset($getsubcat)) ) and ( ($getsubsubcat != "0") and (isset($getsubsubcat)) ) )

	{
		$r_cat = mysql_query ( "SELECT catsubsubsel, subsubcategory FROM $db_subsubcategory WHERE ( (catsel='$getcat' or catsel='$getcategory') and (catsubsel = '$getsubcat') and (catsubsubsel = '$getsubsubcat') )" );
		$f_cat = mysql_fetch_array ( $r_cat );
		$subsubcategory = $f_cat['catsubsubsel'];
		$mainsubsubcategory = $f_cat['subsubcategory'];
		$db->freeresult($r_cat);
	}

	if (($category == "") and ($subcategory == "") and ($subsubcategory == ""))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation ."/EmptyCategory/0-0-0-" . $id . "-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/view.php?id=" . $id . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation ."/" . rewrite($maincategory) . "/" . $category . "-0-0-" . $id . "-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/view.php?id=" . $id . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if (($subcategory != 0) and ($subsubcategory == 0))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation ."/" . rewrite($maincategory) . "/" . rewrite($mainsubcategory) . "/" . $category . "-" . $subcategory . "-0-" . $id . "-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/view.php?id=" . $id . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if ($subsubcategory != 0)
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation ."/" . rewrite($maincategory) . "/" . rewrite($mainsubcategory) . "/" . rewrite($mainsubsubcategory) . "/" . $category . "-" . $subcategory . "-" . $subsubcategory . "-" . $id . "-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/view.php?id=" . $id . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}
}

	$template->replace("flag", $f['flag']);
	$template->replace("company", $f['firmname']);
	$template->replace("description", parseDescription("X", $f['business']));

	$template->replace("new", ifNew($f['date']));
	$template->replace("updated", ifUpdated($f['update_date']));
	$template->replace("hot", ifHot($f['countrating'], $f['votes']));

	// Excel прайсы

	if ((ifEnabled($f[flag], "exel")) and ($def_allow_exel == "YES"))

	{
            $exel_r = $db->query  ( "SELECT num FROM $db_exelp where firmselector = '$f[selector]'" );
            if ( $db->numrows  ( $exel_r ) > 0 ) $exel_link = $def_exel_mark;
            else $exel_link="";
	} else $exel_link="";

	// Видеоролики

	if ((ifEnabled($f[flag], "video")) and ($def_allow_video == "YES"))

	{
        	$video_r = $db->query  ( "SELECT num FROM $db_video where firmselector = '$f[selector]'" );
                if ( $db->numrows  ( $video_r ) > 0 ) $video_link = $def_video_mark;
                else $video_link="";
	} else $video_link="";

	$template->replace("offers", $offers_link);
	$template->replace("images", $images_link);
	$template->replace("exel", $exel_link);
	$template->replace("video", $video_link);

	// Информационный блок

	if ((ifEnabled($f[flag], "infoblock")) and ($def_allow_info == "YES"))

	{	
        	if ( $f[info] > 0 ) $info_link = $def_info_mark;
                else $info_link="";
	} else $info_link="";

	$template->replace("info", $info_link);

	$template->replace("color", $color);

	$template->replace("rating", show_rating ($f['rating'], $f['votes']));
	$template->replace("date", undate($f['date'], $def_datetype));

	$location_r = $db->query  ( "SELECT location FROM $db_location WHERE locationselector = '$f[location]'" );
	$location_f = $db->fetcharray   ( $location_r );

	if ( $def_country_allow == "YES" ) { $country = $location_f['location']; $city = $f['city']; }
	if ( $def_country_allow != "YES" ) { $city = $location_f['location']; $country = ""; }

	if ( $def_states_allow == "YES" ) 
	{
            $state_r = $db->query  ( "SELECT state FROM $db_states WHERE stateselector = '$f[state]'" );
            $state_f = $db->fetcharray   ( $state_r );
            $state = $state_f['state'];
	} else $state = "";

	$template->replace("country", $country);
	$template->replace("state", $state);
	$template->replace("city", $city);

	if (ifEnabled($f[flag], "address")) $template->replace("address", $f['address']); else $template->replace("address", "");
	if (ifEnabled($f[flag], "zip")) $template->replace("zip", $f['zip']); else $template->replace("zip", "");
	if (ifEnabled($f[flag], "phone")) $template->replace("phone", $f['phone']); else $template->replace("phone", "");
	if (ifEnabled($f[flag], "fax")) $template->replace("fax", $f['fax']); else $template->replace("fax", "");
	if (ifEnabled($f[flag], "mobile")) $template->replace("mobile", $f['mobile']); else $template->replace("mobile", "");
	if (ifEnabled($f[flag], "manager")) $template->replace("contact", $f['manager']); else $template->replace("manager", "");
	if (ifEnabled($f[flag], "email")) $template->replace("email", "<a href=mailto:$f[mail]>$f[mail]</a>"); else $template->replace("email", "");
	if (ifEnabled($f[flag], "www")) $template->replace("www", "<a href=$f[www] target=new>$f[www]</a>"); else $template->replace("www", "");

                $rev_good=''; $rev_bad='';

        	if ($f[off_rev] != '1') {

                    if ($f['rev_good']>0) $rev_good = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/rev_good.png" align="absmiddle"> '.$f['rev_good'];
                    if ($f['rev_bad']>0) $rev_bad = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/rev_bad.png" align="absmiddle"> '.$f['rev_bad'];
		}

                $template->replace("rev_good", $rev_good);
                $template->replace("rev_bad", $rev_bad);

	$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	if (( $f['filial'] > 0 ) and (ifEnabled($f['flag'], "filial")))

	{	
		if ($def_rewrite == "YES") $link_filial = $def_mainlocation.'/filial-'.$f[selector].'-0-'.$getcategory.'-'.$getsubcat.'-'.$getsubsubcat.'.html';
		else $link_filial = "filial.php?id=$f[selector]&amp;cat=$getcategory&amp;subcat=$getsubcat&amp;subsubcat=$getsubsubcat";
	
		$template->replace("filial", "<a href=\"$link_filial\" target=\"_blank\">$def_filial_mark</a> [$f[filial]]");

	} else $template->replace("filial", "");

		$template->replace("reserved_1", $f[reserved_1]);
		$template->replace("reserved_2", $f[reserved_2]);
		$template->replace("reserved_3", $f[reserved_3]);

	$template->replace("logo", ifLogo($f[flag], $f[selector], 120));

	$template->replace("icq", "<table cellpadding=0 cellspacing=0 border=0><tr><td align=left valign=middle><a rel=\"nofollow\" href=\"http://web.icq.com/whitepages/add_me?uin=$f[icq]&amp;action=add\">$f[icq]</a></td><td align=left valign=middle>&nbsp;<img src=\"http://web.icq.com/whitepages/online?icq=$f[icq]&amp;img=5\" alt=\"\"><br></td></tr></table>");

        // Формируем список тегов
        $keywords=htmlspecialchars(stripcslashes($f['keywords']));
        if ($keywords!='') $could_tag.=$keywords.', ';

	$template->publish();

}

echo "</table><br>";

?>