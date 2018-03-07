<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: remind.php
-----------------------------------------------------
 Назначение: Напомнить пароль
=====================================================
*/

include ( "./defaults.php" );

if (isset($_GET['douser']) and isset($_GET['lostpsw'])) {

	$douser=intval($_GET['douser']);
	$lostpws=$_GET['lostpsw'];

	$rw=$db->query  ( "SELECT lost, lostmail FROM $db_lost WHERE lostid='$douser' LIMIT 1" );
	$fw = $db->fetcharray  ( $rw );
	$mail=$fw['lostmail'];

		if ( ($fw['lost']!="") and ($lostpws!="") and ($fw['lost']==$lostpws) ) {
		
			$rw=$db->query  ( "SELECT selector, login, mail, firmname FROM $db_users WHERE selector='$douser' and mail='$mail' LIMIT 1" );
			$fw = $db->fetcharray  ( $rw );

			$idl=$fw['selector'];
			$login=$fw['login'];
			$mail=$fw['mail'];

			$salt = "abchefghjkmnpqrstuvwxyz0123456789";
			srand( ( double ) microtime() * 1000000 );
			
			for($i = 0; $i < 9; $i ++) {
				$new_pass .= $salt{rand( 0, 33 )};
			}
			
			$new_pass2 = md5 ( "$new_pass" );

			$db->query  ( "UPDATE $db_users SET pass='$new_pass2' WHERE login = '$login' and mail = '$mail' and selector='$idl' LIMIT 1" );
			$db->query  ( "DELETE FROM $db_lost WHERE lostid='$douser'" );

			$template_mail = file_get_contents ('template/' . $def_template . '/mail/remind_ok.tpl');

                        $template_mail = str_replace("*title*", $def_title, $template_mail);
                        $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                        $template_mail = str_replace("*firmname*", $fw['firmname'], $template_mail);
                        $template_mail = str_replace("*login*", $login, $template_mail);
                        $template_mail = str_replace("*new_pass*", $new_pass, $template_mail);
                        $template_mail = str_replace("*id_firm*", $fw['selector'], $template_mail);

			$to = $mail;
			$from = "$def_reminder <$def_adminmail>";
			$subject = $def_remind_info;

			mailHTML($to,$subject,$template_mail,$from);

			$message = $def_psw_ok_mail;

		} else {

			$db->query  ( "DELETE FROM $db_lost WHERE lostid='$douser'" );
			$message=$def_psw_error_mail;
			
			}
	
}

if ( $_POST["inbut"] == $def_rem_button )

{

	if (( $_POST["mail"] == "") or ((isset($_POST[security])) and ($_POST[security] != "$_SESSION[random]") ))

	{
		$message = "$def_specify $def_login";
	}

	else

	{
		$mail=trim(mysql_real_escape_string($_POST['mail']));

		$r = $db->query  ( "SELECT selector, firmname, login, mail FROM $db_users WHERE mail='$mail'" );
		@$results_amount = mysql_num_rows ( $r );

		if ( $results_amount == "0" )

		{
			$message = $def_not_registered;
		}

		else

		{

if ($results_amount==1)

$template_mail = file_get_contents ('template/' . $def_template . '/mail/remind.tpl');

else

$template_mail = file_get_contents ('template/' . $def_template . '/mail/reminds.tpl');

                        $template_mail = str_replace("*title*", $def_title, $template_mail);
                        $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);

                        $texty='';

			For ($i=0; $i<$results_amount; $i++ )

			{
				$f = $db->fetcharray  ( $r );

                                $salt = "abchefghjkmnpqrstuvwxyz0123456789";
				srand( ( double ) microtime() * 1000000 );
				
				for($j = 0; $j < 15; $j ++) {
					$lostpsw .= $salt{rand( 0, 33 )};
				}
			
				$lostpsw = md5 ( $lostpsw.$f[mail].time() );
				
				$texty.="$def_company: <b>$f[firmname]</b> (ID=$f[selector])<br>";
				$texty.="$def_user_login: <b>$f[login]</b><br>";
				$texty.="$def_psw_link: <b><a href=\"$def_mainlocation/remind.php?douser=$f[selector]&lostpsw=$lostpsw\">$def_mainlocation/remind.php?douser=$f[selector]&lostpsw=$lostpsw</a></b><br><br>";

				$db->query  ( "INSERT INTO $db_lost (lostid, lostmail, lost) VALUES ('$f[selector]', '$f[mail]', '$lostpsw') " );
				
			}

                        $template_mail = str_replace("*data_firm_link*", $texty, $template_mail);
                        $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);

			$to = $f['mail'];
			$from = "$def_reminder <$def_adminmail>";
			$subject = "$def_remind_info";

                        mailHTML($to,$subject,$template_mail,$from);
			
			$message = "$def_psw_tomail";

		}

	}
}

// *********************************************************

$incomingline = $def_reminder;
$help_section = $remind_help;

include ( "./template/$def_template/header.php" );

if ( isset ( $message ) )

{

$def_title_error=$def_yourmessage;
$def_message_error=$message;

include ( "./includes/error_page.php" );

} else {

session_start();

unset($_SESSION['random']);

$_SESSION['random'] = mt_rand(1000000,9999999);

$rand = mt_rand(1, 999);

main_table_top($def_reminder);

$template = new Template;

$template->set_file('remind.tpl');

$template->replace("bgcolor", $def_form_back_color);

$template->replace("mail", $def_psw_mail);
$template->replace("security", "<img src=\"security.php?$rand\" />");
$template->replace("reminder", $def_rem_button);

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

main_table_bottom();

}

include ( "./template/$def_template/footer.php" );

?>