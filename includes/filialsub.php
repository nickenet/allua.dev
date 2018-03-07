<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: filialsub.php
-----------------------------------------------------
 Назначение: Шаблон филиалы
=====================================================
*/

if (!isset($results_amount_2) ) $results_amount_2 = 1;

if (isset($print_f)) $template_sub_filial = implode ('', file('./template/' . $def_template . '/filial_print.tpl'));
else $template_sub_filial = implode ('', file('./template/' . $def_template . '/filial.tpl'));

for ( $iii=0; $iii<$results_amount_2; $iii++ )

{

	$f = $db->fetcharray   ( $re );

	if ( $iii%2 == 0 )

	{

		$color = "$def_form_back_color";

	}

	else

	{

		$color = "$def_background";

	}

	$template = new Template;

	$template->load($template_sub_filial);

	$template->replace("namefilial", "$f[namef]");
	$template->replace("business", "$f[businessf]");

	$link_print="$def_mainlocation/filial.php?print=$f[num]";
	$template->replace("link_print", "$link_print");

	if ($f[countryf]!="") $countryf="<b>$def_country</b>: $f[countryf]<br>"; else $countryf="";
	$template->replace("country", "$countryf");

	if ($f[statef]!="") $statef="<b>$def_state</b>: $f[statef]<br>"; else $statef="";
	$template->replace("state", "$statef");

	$template->replace("city", "<b>$def_city</b>: $f[cityf]<br>");
	$template->replace("address", "<b>$def_address</b>: $f[addressf]<br>");

	if ($f[zipf]!="") $zipf="<b>$def_zip</b>: $f[zipf]<br>"; else $zipf="";
	$template->replace("zip", "$zipf");

	if ($f[phonef]!="") $phonef="<b>$def_phone</b>: $f[phonef]<br>"; else $phonef="";
	$template->replace("phone", "$phonef");

	if ($f[faxf]!="") $faxf="<b>$def_fax</b>: $f[faxf]<br>"; else $faxf="";
	$template->replace("fax", "$faxf");

	if ($f[mobilef]!="") $mobilef="<b>$def_mobile</b>: $f[mobilef]<br>"; else $mobilef="";
	$template->replace("mobile", "$mobilef");

	if ($f[managerf]!="") $managerf="<b>$def_manager</b>: $f[managerf]<br>"; else $managerf="";
	$template->replace("manager", "$managerf");

	if ($f[koordinatif]!="") $koordinatif="$f[koordinatif]<br>"; else $koordinatif="";
	$template->replace("koordinati", "$koordinatif");

	if ( ($def_rewrite == "YES") and ($f[www] != "") ) $template->replace("www", "<b>$def_webpage</b>: <a href=$def_mainlocation/outf-" . $f[num] . ".html target=new>$f[www]</a><br>"); else 
	if ( ($def_rewrite != "YES") and ($f[www] != "") ) $template->replace("www", "<b>$def_webpage</b>: <a href=$def_mainlocation/out.php?fil=$f[num] target=new>$f[www]</a><br>");
	if ( $f[www] == "" ) $template->replace("www", "");

	$img_dir="filial/$f[num].$f[img_type]";

	if (($f[img_on]==1) and (file_exists ($img_dir))) { $img_small="<img src=\"$def_mainlocation/filial/$f[num]-small.$f[img_type]\" alt=\"$f[namef]\" align=\"left\" border=\"0\">"; $img="<img src=\"$def_mainlocation/filial/$f[num].$f[img_type]\" alt=\"$f[namef]\" align=\"left\" border=\"0\">"; } else { $img_small=""; $img=""; }	
	if (($f[img_on]==1) and (file_exists ($img_dir))) $img_link="$def_mainlocation/filial/$f[num].$f[img_type]"; else $img_link="";

	$template->replace("img_small", "$img_small");
	$template->replace("img", "$img");
	$template->replace("img_link", "$img_link");

	$template->replace("firmname", "$f[firmname]");
	$template->replace("title", "$f[firmname] - $def_filial");

	$template->replace("color", "$color");

	$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template->publish();
	

}

?>