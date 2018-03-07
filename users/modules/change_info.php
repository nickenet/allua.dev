<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: change_info.php
-----------------------------------------------------
 Назначение: Изменение информации
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$submit_error = "";

	$firmname = safeHTML ( $_POST["firmname"] );

        $business=safe_business($_POST['tarif'], $_POST['business']);

        $keywords = safeHTML ( strip_tags($_POST['keywords']) );
        $keywords = str_replace("  ", " ", $keywords);
        $twitter = safeHTML($_POST['twitter']);
        $facebook = safeHTML($_POST['facebook']);
        $vk = safeHTML($_POST['vk']);
        $odnoklassniki = safeHTML($_POST['odnoklassniki']);
        $social=$twitter.':'.$facebook.':'.$vk.':'.$odnoklassniki;

	$address = safeHTML ( $_POST["address"] );

	if ( $def_country_allow == "YES" ) $city = safeHTML ( $_POST["city"] );

	$zip = safeHTML ( $_POST["zip"] );
	$phone = safeHTML ( $_POST["phone"] );
	$fax = safeHTML ( $_POST["fax"] );
	$mobile = safeHTML ( $_POST["mobile"] );
	$icq = safeHTML ( $_POST["icq"] );

	$manager = safeHTML ( $_POST["manager"] );
	$mail = safeHTML ( $_POST["mail"] );

	$reserved_1 = safeHTML ( $_POST["reserved_1"] );
	$reserved_2 = safeHTML ( $_POST["reserved_2"] );
	$reserved_3 = safeHTML ( $_POST["reserved_3"] );

		if ( $_POST["www"] <> "" )

		{
			if ( preg_match("#http://#", $_POST["www"]) ) { $www = $_POST[www]; }
			elseif ( preg_match("#https://#", $_POST["www"]) ) { $www = $_POST[www]; }
			else { $www = "http://$_POST[www]"; }
		}

		$www = safeHTML ( $www );
                
                // Проверка на ошибки

		if ( $firmname == "" ) $submit_error.= "$def_specify $def_company<br>";

		if ( $business == "" ) $submit_error.= "$def_specify $def_description<br>";

		if ( ( $def_country_allow == "YES" ) and ( $city == "" ) ) $submit_error.= "$def_specify $def_city<br>";

		if ( $mail == "" ) $submit_error.= "$def_specify $def_email<br>";

		if ( count($_POST[category]) > $def_categories) $submit_error.= "$def_simcat<br>";

		if ( $_POST["password"] == "" ) $submit_error.= "$def_specify $def_pass<br>";

		if ( $_POST["password"] <> $_POST["password2"] ) $submit_error.= "$def_passwords_missmatch<br>";

		if ( strlen ( $_POST["password"] ) < "4"  ) $submit_error.= "$def_pass_short<br>";

		if ( strpos($_POST['password'], ' ') !== false ) $submit_error.= "$def_reg_nospaces_commas<br>";

		if ( strpos($_POST['password'], '"') !== false ) $submit_error.= "$def_reg_nospaces_commas<br>";

		$ip = $_SERVER["REMOTE_ADDR"];

		if ( $f[pass] == $_POST["password"] ) $pass = $_POST[password];

		if ($submit_error == "")

		{
			if ( $f[pass] <> $_POST["password"] )

			{
				$pass = my_crypt ( $_POST[password] );
				$_SESSION['pass'] = my_crypt ( $_POST["password"] );
			}
		}
		$date = date ( "Y-m-d" );

		if ( $def_country_allow == "YES" )

		{
			$location = $_POST["country"];
			$postedcity=$city;
		}

		else

		{
			$location = $_POST["city2"];
			$postedcity = "";
		}

		if ( $def_states_allow == "YES" )

		{
			$state = $_POST["state"];
		}

		if ($submit_error == "")

		{
			// $r = $db->query  ( "SELECT * FROM $db_users WHERE login='$_SESSION[login]'" );
			// $f = $db->fetcharray  ( $r );


			If ($f[firmstate]!="off") $category = update_categories_user ($f['flag'], $f['flag'], $f['category'], $_POST['category'], "public");
			else  $category=implode ("#", $_POST['category']);

                        if ($mail!=$f['mail']) $db->query  ( "UPDATE $db_users SET tmail='0' WHERE login='$_SESSION[login]'" );

			$db->query  ( "UPDATE $db_users SET category='$category', firmname='$firmname', keywords='$keywords', business='$business', location='$location', state='$state', city='$postedcity', address='$address', zip='$zip', phone='$phone', fax='$fax', mobile='$mobile', icq='$icq', manager='$manager', mail='$mail', www='$www', social='$social', pass='$pass', date_update='$date', ip_update='$ip', reserved_1='$reserved_1', reserved_2='$reserved_2', reserved_3='$reserved_3'   WHERE login='$_SESSION[login]'" );

			echo "<center><div align=\"center\" id=\"messages\">Ваши данные успешно обновлены! <img src=\"$def_mainlocation/users/template/images/ok.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\" align=\"middle\"></div></center>";
		}
		
		else
	
		{
                    
		echo "<center><div align=\"center\" id=\"messages\"><img src=\"$def_mainlocation/users/template/images/error.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\"><br><font color=red><b>Ошибка!</b></font><br>$submit_error</div></center>";
		
		}

?>