<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: data_firm.php
-----------------------------------------------------
 Назначение: Подключение основных данных компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

                $template->replace("flag", $f['flag']);
                $template->replace("date", undate($f['date'], $def_datetype));
              
                $template->replace("company", $f['firmname']);
                $f['business']=stripcslashes($f['business']);
		$template->replace("description", $f['business']);

                $template->replace("new", ifNew($f['date']));
		$template->replace("updated", ifUpdated($f['update_date']));
		$template->replace("hot", ifHot($f['countrating'], $f['votes']));

		$template->replace("kodirating", $kod_top);

		$template->replace("rating", show_rating ($f['rating'], $f['votes']));

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

		if (ifEnabled($f['flag'], "address")) $template->replace("address", $f['address']); else $template->replace("address", "");
		if (ifEnabled($f['flag'], "zip")) $template->replace("zip", $f['zip']); else $template->replace("zip", "");
		if (ifEnabled($f['flag'], "phone")) $template->replace("phone", $f['phone']); else $template->replace("phone", "");
		if (ifEnabled($f['flag'], "fax")) $template->replace("fax", $f['fax']); else $template->replace("fax", "");
		if (ifEnabled($f['flag'], "mobile")) $template->replace("mobile", $f['mobile']); else $template->replace("mobile", "");
		if (ifEnabled($f['flag'], "manager")) $template->replace("contact", $f['manager']); else $template->replace("manager", "");

		if ( (ifEnabled($f['flag'], "www")) and ($f['www'] != "") ) {

			if ($def_rewrite == "YES") $template->replace("www", "<noindex><a rel=\"nofollow\" href=\"$def_mainlocation/out-$f[selector].html\" target=\"_blank\">$f[www]</a></noindex>");
			else $template->replace("www", "<noindex><a rel=\"nofollow\" href=\"$def_mainlocation/out.php?ID=$f[selector]\" target=\"_blank\">$f[www]</a></noindex>");

		} else $template->replace("www", "");

		if ( $f[www] == "" ) $template->replace("www", $def_www_not);

                    if ($form_set[13]!='') $def_sendmessage=$form_set[13];
                    if ( (ifEnabled($f['flag'], "email")) and ($def_rewrite == "YES") and ($f['off_mail'] != '1') ) $mail = '<a href="'.$def_mainlocation.'/mail-'.$f['selector'].'-'.$category_list[0].'-'.$category_list[1].'-'. $category_list[2].'-0.html">'.$def_sendmessage.'</a>';
                    if ( (ifEnabled($f['flag'], "email")) and ($def_rewrite != "YES") and ($f['off_mail'] != '1') ) $mail = '<a href="'.$def_mainlocation.'/mail.php?id='.$f['selector'].'&amp;cat='.$category_list[0].'&amp;subcat='.$category_list[1].'&amp;subsubcat='.$category_list[2].'">'.$def_sendmessage.'</a>';
                    if (!ifEnabled($f['flag'], "email")) $mail = $def_not_email;
                    if ($f['off_mail'] == '1') $mail = $def_closed_company;
                    if ($f['mail'] == '') $mail = $def_not_mail;

                    $template->replace("mail", $mail);

                // Статистика
                if ($hits_m_site==0) $hits_m_site=1; $hits_m_site=$f['hits_m'];
                if ($hits_d_site==0) $hits_d_site=1; $hits_d_site=$f['hits_d'];
		$template->replace("hits", $f['counter']);
                $template->replace("hits_d", $hits_d_site);
                $template->replace("hits_m", $hits_m_site);

		$template->replace("contact", $f['manager']);

		if ($f[icq] != "") $template->replace("icq", "<table cellpadding=0 cellspacing=0 border=0><tr><td align=left valign=middle><a rel=\"nofollow\" href=\"http://www.icq.com/people/$f[icq]\">$f[icq]</a></td><td align=left valign=middle>&nbsp;<img src=\"http://web.icq.com/whitepages/online?icq=$f[icq]&amp;img=5\" alt=\"$f[icq]\"><br></td></tr></table>");
                else $template->replace("icq", "");

		$template->replace("logo", ifLogo($f['flag'], $f['selector'], "",$f['firmname']));
		$template->replace("sxema", ifSxema($f['flag'], $f['selector'], ""));

                $template->replace("reserved_1", $f['reserved_1']);
		$template->replace("reserved_2", $f['reserved_2']);
		$template->replace("reserved_3", $f['reserved_3']);

                // Ключевые слова - метки, теги

                if ($f['keywords']!='') { $keywords = array();
                $f['keywords'] = explode(",", htmlspecialchars(stripcslashes($f['keywords']),ENT_QUOTES,$def_charset));

                    foreach($f['keywords'] as $value)  {
                        $value = trim ($value);
                        $keywords[] = "<a href=\"$def_mainlocation/tag.php?skey=". urlencode( $value ) ."\">$value</a>";
                    }
                        $keywords=implode(", ",$keywords);
                } else $keywords='';

                $template->replace("keywords", $keywords);

                // Проверка документов компании
                if ($f['tcase']==1) {
                    $case_firm='<img alt="'.$def_case_message_box.'" title="'.$def_case_message_box.'" src="'.$def_mainlocation.'/template/'.$def_template.'/images/case_ok.png" border="0" />';
                } else $case_firm='';

                $template->replace("case", $case_firm);
?>
