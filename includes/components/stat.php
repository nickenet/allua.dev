<?php
/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: stat.php
-----------------------------------------------------
 Назначение: Файл статистики и рейтинга фирм
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

		@$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		if ($ip == "") $ip=$_SERVER["REMOTE_ADDR"];

		if ($ip !=  $ip_table) $db->query ( "UPDATE $db_users SET counter = counter+1, hits_d=hits_d+1, hits_m=hits_m+1, counterip = '$ip' WHERE selector='$id'" );

                    $s_year=date(Y);
                    $s_month=date(m);
                    $s_month="m$s_month";
                
                if ($hits_m==0) {

                    $db->query  ( "INSERT INTO $db_engines (firmselector) VALUES ('$id')" ) or die (mysql_error());
                    $db->query  ( "INSERT INTO $db_stat (firmselector,year,$s_month) VALUES ('$id','$s_year','1')" ) or die (mysql_error());
                    $db->query ( "UPDATE $db_users SET hits_m = 1, hits_d = 1 WHERE selector='$id'" );
                    
                } else {

                    if (ifEnabled($f['flag'], "stat")) {
               
                        if ($ip !=  $ip_table) @ $db->query ( "UPDATE $db_stat SET $s_month = $s_month + 1, year = '$s_year' WHERE firmselector='$id'" );

                        // Определяем основные поисковые системы и социалки

                            $search_engines='yandex#google#bing#mail#yahoo#rambler#aport';
                            $search_engines=explode("#",$search_engines);

                            $search_social='bit.ly#t.co#twitter.com#my.mail.ru#facebook.com#odnoklassniki.ru#vk.com';
                            $serch_social_baza='twitter#twitter#twitter#mymail#facebook#odnoklassniki#vk';
                            $search_social=explode("#",$search_social);
                            $search_social_baza=explode("#",$serch_social_baza);

                            $http_referer=parse_url ($_SERVER['HTTP_REFERER']);
                            $http_referer_engines=str_replace ("www.","",$http_referer);
                            $http_referer_social=str_replace ("www.","",$http_referer);

                            $engines_yes='';
                            $social_yes='';

                            foreach ($search_engines as $value) {
                                    if (preg_match("/^$value/", $http_referer_engines[host])) $engines_yes=$value;
                            }
                            unset($value);


                            $fg=0;
                            foreach ($search_social as $value) {
                                    if (preg_match("/^$value/", $http_referer_social[host])) $social_yes=$fg;
                            $fg++;
                            }
                            if ($social_yes!='') @ $db->query ( "UPDATE $db_engines SET $search_social_baza[$social_yes] = $search_social_baza[$social_yes] + 1 WHERE firmselector='$id'" );
		            if ($engines_yes!='') @ $db->query ( "UPDATE $db_engines SET $engines_yes = $engines_yes + 1 WHERE firmselector='$id'" );
		            
                    }
                }
?>
