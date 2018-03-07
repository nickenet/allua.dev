<?

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
 Назначение: Проверка компаний размещенных в ПТ
=====================================================
*/

if (empty($_SESSION['counter']) or ($_SESSION['counter']=='NO')) {

		$sql = "SELECT flag, selector, firmname, date_upgrade FROM $db_users
	        WHERE
	         (";

		if ($def_A_expiration != "0") $sql.= "( (flag = 'A') AND (loch_m!='1') AND ( ( ". $def_A_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";
		if ($def_B_expiration != "0") $sql.= "( (flag = 'B') AND (loch_m!='1') AND ( ( ". $def_B_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";
		if ($def_C_expiration != "0") $sql.= "( (flag = 'C') AND (loch_m!='1') AND ( ( ". $def_C_expiration ." - (TO_DAYS(NOW()) - TO_DAYS(date_upgrade)) <= $def_paypal_expiration_warning ) ) ) OR ";

		$sql.= " flag = 'Z' )";

		$r_pay = $db->query ($sql);
		if (!$r_pay) error ("mySQL error", mysql_error() );

                if ($db->numrows ( $r_pay )>0) {

		for ( $i=0;$i<$db->numrows ( $r_pay );$i++ )

		{
			$f_pay_pay = $db->fetcharray ( $r_pay );

                        IF ($f_pay_pay["date_upgrade"]<>"") {

      				$date_day = date ( "d" );
				$date_month = date ( "m" );
				$date_year = date ( "Y" );

				list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f_pay_pay["date_upgrade"] );

				$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
				$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

				if ( $second_date > $first_date )

				{ $days = $second_date - $first_date; }

				else

				{ $days = $first_date - $second_date; }

				if ($f_pay_pay[flag] == "A") $expir = $def_A_expiration;
				if ($f_pay_pay[flag] == "B") $expir = $def_B_expiration;
				if ($f_pay_pay[flag] == "C") $expir = $def_C_expiration;

				$current_result = $expir - ( ( $days ) / ( 60 * 60 * 24 ) );
                        }

			$_SESSION['end_pay_tariff'] .= '<img src="images/tree.gif" width="31" height="17" align="absmiddle" /><a class="slink" href="offers.php?REQ=auth&id='.$f_pay_pay['selector'].'">'.$f_pay_pay['firmname'].'</a> ('.$current_result.')<br />';
		}

		@	  $db->freeresult($r_pay);

                $_SESSION['warning_pay']='YES';

                }

                $_SESSION['counter']='YES';

}

?>