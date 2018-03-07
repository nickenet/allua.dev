<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: cron.php
-----------------------------------------------------
 Назначение: cron
=====================================================
*/


if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$counter = file ( "counter.txt",1 );
$counts = explode ( "::", $counter[0] );

$ip = $_SERVER["REMOTE_ADDR"];

$seconds = time();
$day = date ( "d" );

if ( ( $counts[1] <> $ip ) or ( ( $seconds-$counts[2] ) > 1800 ) )

{

	$counts[0] = $counts[0]+1;

	if ( $day <> "$counts[3]" )

	{
		$counts[4]=0;

                $db->query ( "UPDATE $db_users SET hits_d = 0, counterip = ''" ); // Обнуляем число просмотров за день
                if ($day=='01') $db->query ( "UPDATE $db_users SET hits_m = 1, webcounter = 0" ); // ставим один просмотр за месяц всем фирмам и обнуляем статистику по сайтам

		// CHECK FOR EXPIRED PRODUCTS AND SERVICES

		$sql = "SELECT num, period FROM $db_offers
		WHERE 
		(( period - ( TO_DAYS(NOW()) - TO_DAYS(date) ) <= 0 ) and (period!=0))
		";

		$ra = $db->query ( $sql );
		if (!$ra) error ("mySQL error", mysql_error);

		$results_amount1 = $db->numrows ( $ra );

		for ( $i1=0;$i1<$results_amount1;$i1++ )

		{

			$fa = $db->fetcharray ( $ra );

			@unlink("./offer/$fa[num].gif");
			@unlink("./offer/$fa[num].bmp");
			@unlink("./offer/$fa[num].jpg");
			@unlink("./offer/$fa[num].png");

			@unlink("./offer/$fa[num]-small.gif");
			@unlink("./offer/$fa[num]-small.bmp");
			@unlink("./offer/$fa[num]-small.jpg");
			@unlink("./offer/$fa[num]-small.png");

			$db->query("DELETE FROM $db_offers where num='$fa[num]'");

		}

		@	  $db->freeresult($ra);


		// УДАЛЕНИЕ ПУБЛИКАЦИЙ ПО ИСТЕЧЕНИЮ СРОКА

		$sql = "SELECT * FROM $db_info 
		WHERE 
		(( period - ( TO_DAYS(NOW()) - TO_DAYS(date) ) <= 0 ) and (period!=0))
		";

		$vi = $db->query ( $sql );
		if (!$vi) error ("mySQL error CRON.php", mysql_error);

		$results_amount3 = $db->numrows ( $vi );

		for ( $i3=0;$i3<$results_amount3;$i3++ )

		{

			$vid = $db->fetcharray ( $vi );

			@unlink("./info/$vid[num].gif");
			@unlink("./info/$vid[num].bmp");
			@unlink("./info/$vid[num].jpg");
			@unlink("./info/$vid[num].png");

			@unlink("./info/$vid[num]-small.gif");
			@unlink("./info/$vid[num]-small.bmp");
			@unlink("./info/$vid[num]-small.jpg");
			@unlink("./info/$vid[num]-small.png");

			$db->query  ( "DELETE FROM $db_info WHERE num='$vid[num]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (cron.php)" );

			$ut = $db->query  ( "SELECT info, news, tender, board, job, pressrel FROM $db_users WHERE selector='$vid[firmselector]'" )
			or die ( "ERROR011: mySQL error, can't delete from INFO. (cron.php)" );

			$fu = $db->fetcharray ( $ut );

			$all_info=$fu[info]-1;

			if ($vid[type]==1) { $up_type=$fu[news]-1; $sql_up=" , news='$up_type' "; }
			if ($vid[type]==2) { $up_type=$fu[tender]-1; $sql_up=" , tender='$up_type'"; }
			if ($vid[type]==3) { $up_type=$fu[board]-1; $sql_up=" , board='$up_type'"; }
			if ($vid[type]==4) { $up_type=$fu[job]-1; $sql_up=" , job='$up_type'"; }
			if ($vid[type]==5) { $up_type=$fu[pressrel]-1; $sql_up=" , pressrel='$up_type'"; }	
				
			$db->query  ( "UPDATE $db_users SET info='$all_info' $sql_up WHERE selector='$vid[firmselector]'" )
			or die ( "ERROR012: mySQL error, can't update USERS. (cron.php)" );

		}

		@	  $db->freeresult($vi);

		// CHECK FOR LISTINGS WITH EXPIRED MEMBERSHIP (A, B, C)

                $template_mail = file_get_contents ('template/' . $def_template . '/mail/discontinued.tpl');

		$sql = "SELECT selector, category, mail, prices, images, firmname FROM $db_users
	        WHERE 
	         (";

		if ($def_A_expiration != "0") $sql.= "( (flag = 'A') AND (loch_m!='1') AND ( ( ". $def_A_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= 0 ) ) ) OR ";
		if ($def_B_expiration != "0") $sql.= "( (flag = 'B') AND (loch_m!='1') AND ( ( ". $def_B_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= 0 ) ) ) OR ";
		if ($def_C_expiration != "0") $sql.= "( (flag = 'C') AND (loch_m!='1') AND ( ( ". $def_C_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= 0 ) ) ) OR ";

		$sql.= " flag = 'Z' )";

		$r = $db->query ($sql);
		if (!$r) error ("mySQL error", mysql_error() );

		$results_amount = $db->numrows ( $r );

		for ( $i2=0;$i2<$results_amount;$i2++ )

		{
			$f = $db->fetcharray ( $r );

                        $template_mail_disc=$template_mail;
                        $template_mail_disc = str_replace("*title*", $def_title, $template_mail_disc);
                        $template_mail_disc = str_replace("*dir_to_main*", $def_mainlocation, $template_mail_disc);
                        $template_mail_disc = str_replace("*firmname*", $f['firmname'], $template_mail_disc);

			switchmemberships ($f[selector], "D", "public", "cron");

                        if ($f['mail']!='') mailHTML($f['mail'],$discontinued_subject,$template_mail_disc,$def_from_email);
		}

                // WARN PAID LISTINGS WHICH ARE
		// ABOUT TO EXPIRE (A, B, C)

                $template_mail = file_get_contents ('template/' . $def_template . '/mail/warning.tpl');

		$sql = "SELECT mail, firmname FROM $db_users
	        WHERE
	         (";

		if ($def_A_expiration != "0") $sql.= "( (flag = 'A') AND (loch_m!='1') AND ( ( ". $def_A_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";
		if ($def_B_expiration != "0") $sql.= "( (flag = 'B') AND (loch_m!='1') AND ( ( ". $def_B_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";
		if ($def_C_expiration != "0") $sql.= "( (flag = 'C') AND (loch_m!='1') AND ( ( ". $def_C_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";

		$sql.= " flag = 'Z' )";

		$r = $db->query ($sql);
		if (!$r) error ("mySQL error", mysql_error() );

		for ( $i=0;$i<$db->numrows ( $r );$i++ )

		{
			$f = $db->fetcharray ( $r );

                        $template_mail_warn=$template_mail;
                        $template_mail_warn = str_replace("*title*", $def_title, $template_mail_warn);
                        $template_mail_warn = str_replace("*dir_to_main*", $def_mainlocation, $template_mail_warn);
                        $template_mail_warn = str_replace("*firmname*", $f['firmname'], $template_mail_warn);

                        if ($f['mail']!='') mailHTML($f['mail'],$warn_subject,$template_mail_warn,$def_from_email);
		}

		@	  $db->freeresult($r);
	}

        $year=date(Y);
        
        if ($counts[5]<>$year) $db->query ( "UPDATE $db_stat SET year = '$year', m01='0', m02='0', m03='0', m04='0', m05='0', m06='0', m07='0', m08='0', m09='0', m10='0', m11='0', m12='0'" ); // ставим один просмотр за месяц всем фирмам

	$counts[4] = $counts[4]+1;
	
	$counter = fopen ( "counter.txt" , "w+" );
	rewind ( $counter );
	fputs ( $counter, "$counts[0]::$ip::$seconds::$day::$counts[4]::$year" );
	fclose ( $counter );
}

?>