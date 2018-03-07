<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: reg.php
-----------------------------------------------------
 Назначение: Регистрация в каталоге
=====================================================
*/

include ( "./defaults.php" );

$incomingline = $def_reg;

$help_section = $reg_help;

if ($def_security_enable == "YES") {

	session_start();

	header("Cache-control: private");

        if (!isset($_SESSION['random'])) $_SESSION['random'] = mt_rand(1000000,9999999);

	$rand = mt_rand(1, 999);

}

if (!empty($_POST['do_check']) && $_POST['do_check'] == 'firm')
{
	ob_clean();
	$check = safeHTML($_POST['check']);
	$check = trim($check);
	$check = iconv('CP1251', 'UTF-8', $check);
	
	$cleanList = array('ЧП', 'АО', 'ИП', 'ООО', 'ОО', 'ТОО');
	foreach ($cleanList as &$row)
	{
		$row = '#^' . $row . '\s#i';
	}
	
	unset($row);
	$check = preg_replace($cleanList, '', $check);
	
	$res = $db->query("SELECT selector, firmname FROM $db_users WHERE firmname LIKE '%$check%' LIMIT 5");
	$found = false;
	$msg_v='';
	while($row = $db->fetcharray($res))
	{
		$found = true;
		$msg = iconv('CP1251', 'UTF-8', $row['firmname']);
		$msg_v.= '<a href="view.php?id=' . $row['selector'] . '" target="_blank">' . $msg . '</a><br>';
	}
	
	if (!$found)
	{
		$msg = 'Похожие компании в базе отсутствуют.';
		$msg = iconv('CP1251', 'UTF-8', $msg);
		header("Content-type: text/html; charset=UTF-8");
		echo $msg;
	}

	else

	{

	header("Content-type: text/html; charset=UTF-8");
	echo $msg_v;

	}

	exit;
}

if (!empty($_POST['do_check']) && $_POST['do_check'] == 'login')
{
	ob_clean();
	$check = safeHTML($_POST['check']);
	$check = trim($check);
	$check = iconv('UTF-8', 'CP1251', $check);
	
	$res = $db->query("SELECT login FROM $db_users WHERE login = '$check' LIMIT 1");
	$row = $db->fetcharray($res);
	
	if (empty($row))
	{
		$msg = 'Логин свободен.';
	}
	else
	{
		$msg = 'Логин существует.';
	}
	
	$msg = iconv('CP1251', 'UTF-8', $msg);
	header("Content-type: text/html; charset=UTF-8");
	echo $msg;

	exit;
}

if (!empty($_POST['do_check']) && $_POST['do_check'] == 'domen')
{
	ob_clean();
	$check = safeHTML($_POST['check']);
	$check = trim($check);
	$check = iconv('UTF-8', 'CP1251', $check);

	$res = $db->query("SELECT domen FROM $db_users WHERE domen = '$check' LIMIT 1");
	$row = $db->fetcharray($res);

	if (empty($row))
	{
		$msg = 'Имя свободно.';
	}
	else
	{
		$msg = 'Имя существует.';
	}

	$msg = iconv('CP1251', 'UTF-8', $msg);
	header("Content-type: text/html; charset=UTF-8");
	echo $msg;

	exit;
}

if ( $_POST['regbut'] == $def_reg )

			{
				$firmname = safeHTML($_POST['firmname']);
				$business = safeHTML($_POST['business']);
                                $keywords = safeHTML ( strip_tags($_POST['keywords']) );
                                $keywords = str_replace("  ", " ", $keywords);
                                $twitter = safeHTML($_POST['twitter']);
                                $facebook = safeHTML($_POST['facebook']);
                                $vk = safeHTML($_POST['vk']);
                                $odnoklassniki = safeHTML($_POST['odnoklassniki']);
                                $social=$twitter.':'.$facebook.':'.$vk.':'.$odnoklassniki;

                                $domen = safeHTML( strip_tags($_POST['domen']));
                                $domen = rewrite($domen);
                                $r_d = $db->query  ( "SELECT selector FROM $db_users WHERE domen='$domen'" );
				$domens = mysql_num_rows ( $r_d );

				$address = safeHTML($_POST['address']);

				if ( $def_country_allow == "YES" ) $city = safeHTML($_POST['city']);

                                $zip = safeHTML($_POST['zip']);

				$phone = safeHTML($_POST['phone']);
				$fax = safeHTML($_POST['fax']);
				$mobile = safeHTML($_POST['mobile']);

				$icq = safeHTML($_POST['icq']);

				$manager = safeHTML($_POST['manager']);
				$mail = safeHTML($_POST['mail']);

				$reserved_1 = safeHTML($_POST['reserved_1']);
				$reserved_2 = safeHTML($_POST['reserved_2']);
				$reserved_3 = safeHTML($_POST['reserved_3']);

				if ( $_POST['www'] <> "" ) {
					if ( preg_match("#http://#", $_POST["www"]) ) { $www = $_POST[www]; }
					elseif ( preg_match("#https://#", $_POST["www"]) ) { $www = $_POST[www]; }
					else { $www = "http://$_POST[www]"; }
                                        $www = safeHTML ( $www );
				}
                                
                                $login_select=safeHTML($_POST['login']);
				$r = $db->query ("SELECT selector FROM $db_users WHERE login='$login_select'");
				$logins = mysql_num_rows ( $r );
				$db->freeresult  ( $r );

                                $index_category = 1;
				for ($index = 0; $index < count ( $_POST['category'] ); $index++)	{
				
                                    if ($_POST[category][$index] != "") {$category_index[$index_category] = $_POST[category][$index];$index_category++;}
                                    
				}

				@ $category = join(":", $category_index);

				if (($def_security_enable == "YES") and ( $_POST[security] != "$_SESSION[random]" )) { $error_reg .= "$def_specify $def_security.<br><br>";  $error_on = 1;}

				elseif ( count($_POST[category]) == 0 ) { $error_reg .= "$def_specify $def_category.<br><br>";  $error_on = 1;}

				elseif ( count($_POST[category]) > $def_categories) { $error_reg .= "$def_simcat<br><br>"; $error_on = 1;}
				elseif ( $firmname == "" ) { $error_reg .= "$def_specify $def_company.<br><br>";  $error_on = 1;}
				elseif ( $business == "" ) { $error_reg .= "$def_specify $def_description.<br><br>";  $error_on = 1;}
				elseif ( $mail == "" ) { $error_reg .= "$def_specify $def_email.<br><br>";  $error_on = 1;}

				elseif ( ( $def_country_allow == "YES" ) and ( $city == "" ) ) { $error_reg .= "$def_specify $def_city.<br><br>";  $error_on = 1;}

				elseif (isset ($_POST['pass']) &&  $_POST['pass'] != $_POST['pass2']) { $error_reg .= "$def_passwords_missmatch.<br><br>";  $error_on = 1;}
				elseif ( strlen ( $_POST["login"] ) < "4" ) { $error_reg .= "$def_login_short<br><br>";  $error_on = 1;}
				elseif ( strlen ( $_POST["pass"] ) < "4" ) { $error_reg .= "$def_pass_short<br><br>";  $error_on = 1;}
				
				elseif ( 
 				    strpos($_POST['login'], ' ') !== false || strpos($_POST['login'], '"') !== false 
				  || strpos($_POST['pass'],  ' ') !== false || strpos($_POST['pass'],  '"') !== false) 
				{ 
				  $error_reg .= "$def_reg_nospaces_commas.<br><br>";
				  $error_on = 1; 
				}

				elseif ( $logins > 0 ) { $error_reg .= "$def_reg_login_used.<br><br>";  $error_on = 1;}
                                elseif ( $domenss > 0 ) { $error_reg .= "$def_reg_domen_used.<br><br>>";  $error_on = 1;}

				else

				{
					$ip = $_SERVER["REMOTE_ADDR"];

					$date = date( "Y-m-d" );

					if ( $def_country_allow == "YES" ) {

						$location = $_POST['location'];
						$postedcity = $city;
					}

					else {

						$location = $_POST['location'];
						$postedcity = "";
					}

					if ( $def_states_allow == "YES" ) $state = $_POST['state'];

					$pass = my_crypt($_POST['pass']);

					$login = safeHTML($_POST['login']);

					if ( ($def_autoapprove == "YES") or ($def_reg_payments == "YES") )
					{$flag="D"; $status="on";$images = $def_D_setimages;$products = $def_D_setproducts;$exel=$def_D_setexel;$video=$def_D_setvideo;}
					else
					{$flag=""; $status="off";$images = 0;$products = 0;$exel=0;$video=0;}

                                        $casemail = mt_rand(10000,99999);

					$db->query  ( "INSERT INTO $db_users (flag, firmstate, category, login, firmname, domen, business, keywords, location, state, city, address, zip, phone, fax, mobile, icq, manager, mail, tmail, www, social, pass, prices, images, exel, video, ip, date, counter, banner_show, banner_click, price_show, reserved_1, reserved_2, reserved_3) VALUES ('$flag', '$status', '$category', '$login', '$firmname', '$domen', '$business', '$keywords', '$location', '$state', '$postedcity', '$address', '$zip', '$phone', '$fax', '$mobile', '$icq', '$manager', '$mail', $casemail, '$www', '$social', '$pass', '$products', '$images', '$exel', '$video', '$ip', '$date', 1, 0, 0, 0, '$reserved_1', '$reserved_2', '$reserved_3')" ) or die (mysql_error());

                                        $id_firm_code=mysql_insert_id();

					if (($def_security_enable == "YES") and ( $_POST[security] == $_SESSION['random'] )) unset($_SESSION['random']);

					if ( (($def_autoapprove == "YES") and ($def_onlypaid != "YES")) or (($def_reg_payments == "YES") and ($def_onlypaid != "YES")) )

					{
						$index_category = 1;

						$category = explode (":", $category);

						for ($index = 0; $index < count ( $category ); $index++)

						{
							if ($def_onlypaid != "YES")

							{
								$new_cat = explode ("#", $category[$index]);

								if ($new_cat[0] != $prev_cat)

								$db->query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat[0]") or die ("mySQL error1!");

								if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

								$db->query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]") or die ("mySQL error2!");

								if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

								$db->query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]") or die ("mySQL error3!");
							}

							$prev_cat=$new_cat[0];
							$prev_subcat=$new_cat[1];
						}
					}

if ($def_notify == "YES") {

    $template_mail = file_get_contents ('template/' . $def_template . '/mail/reg_new_firm.tpl');

    $template_mail = str_replace("*title*", $def_title, $template_mail);
    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
    $template_mail = str_replace("*firmname*", $firmname, $template_mail);
    $template_mail = str_replace("*login*", $login, $template_mail);
    $template_mail = str_replace("*pass*", htmlspecialchars($_POST['pass'],ENT_QUOTES,$def_charset), $template_mail);
    $template_mail = str_replace("*mail*", $mail, $template_mail);
    $template_mail = str_replace("*date*", $date, $template_mail);
    $template_mail = str_replace("*address*", $address, $template_mail);
    $template_mail = str_replace("*phone*", $phone, $template_mail);
    $template_mail = str_replace("*www*", $www, $template_mail);
    $template_mail = str_replace("*manager*", $manager, $template_mail);
    $template_mail = str_replace("*domen*", $domen, $template_mail);
    $template_mail = str_replace("*business*", $business, $template_mail);

    mailHTML($def_adminmail,$def_ok_reg_firm_mail,$template_mail,$def_adminmail);

    $template_mail_klient = file_get_contents ('template/' . $def_template . '/mail/reg_new_firm_klient.tpl');

    $template_mail_klient = str_replace("*title*", $def_title, $template_mail_klient);
    $template_mail_klient = str_replace("*dir_to_main*", $def_mainlocation, $template_mail_klient);
    $template_mail_klient = str_replace("*firmname*", $firmname, $template_mail_klient);
    $template_mail_klient = str_replace("*login*", $login, $template_mail_klient);
    $template_mail_klient = str_replace("*pass*", htmlspecialchars($_POST['pass'],ENT_QUOTES,$def_charset), $template_mail_klient);

    $link_case_mail=$def_mainlocation.'/users/user.php?id='.$id_firm_code.'&code='.$rand = $casemail;

    $template_mail_klient = str_replace("*casemail*", $casemail, $template_mail_klient);
    $template_mail_klient = str_replace("*link_mail*", $link_case_mail, $template_mail_klient);
    
    $template_mail_klient = str_replace("*mail*", $mail, $template_mail_klient);
    $template_mail_klient = str_replace("*date*", $date, $template_mail_klient);
    $template_mail_klient = str_replace("*address*", $address, $template_mail_klient);
    $template_mail_klient = str_replace("*phone*", $phone, $template_mail_klient);
    $template_mail_klient = str_replace("*www*", $www, $template_mail_klient);
    $template_mail_klient = str_replace("*manager*", $manager, $template_mail_klient);
    $template_mail_klient = str_replace("*domen*", $domen, $template_mail_klient);
    $template_mail_klient = str_replace("*business*", $business, $template_mail_klient);

    
    mailHTML($mail,$def_ok_reg_firm_mail_klietn,$template_mail_klient,$def_adminmail);

}

$inv_date = date("YmdHis");

						// Регистрируем клиента в базе ДЛЕ сайта
						IF (($def_int_dle=="YES") and ($def_reg_dle=="NO")) {
							unset ($db);
							include_once ('../engine/api/api.class.php');
							$group=4;
							$reg_dle=$dle_api->external_register($_POST["login"], $_POST["pass"], $mail, $group);
							unset ($db);
							include ('connect.php');
								if ($reg_dle!=1) {
									if ($reg_dle==-1) echo "Пользователь с указанным логином существует в базе основного сайта";
									if ($reg_dle==-2) echo "Пользователь с указанным e-mail существует в базе основного сайта";
									if ($reg_dle==0) echo "Соединение с базой данных основного сайта не установлено";
                                                                        die();
								}
						}
                                                
$_SESSION['login']=$login;
$_SESSION['pass']=$pass;
$_SESSION['ident'] = time();
$ip = $_SERVER["REMOTE_ADDR"];
$_SESSION['auth'].= $ip;

$nonce = mt_rand(1, 10000000);
$nonce = md5($nonce);
$_SESSION['nonce'] = $nonce; 

header("Location: users/user.php?REQ=authorize");
                                                
include ( "./template/$def_template/header.php" );

main_table_top ($def_reg);

if ( ($def_autoapprove != "YES") and ($def_reg_payments != "YES") ) echo "<br>$def_reg_ok<br>";

if ($def_autoapprove == "YES")  echo "<br>$def_reg_ok_approved<br>";

if ($def_reg_payments == "YES")  echo "$def_reg_ok_approved_pay_now <br><br>"; 

main_table_bottom ();

}
}

include ( "./template/$def_template/header.php" );

?>

<script type="text/javascript" src="includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="includes/messages_ru.js"></script>

<?

if ( (($error_on == 1) and ( $_POST["regbut"] == "$def_reg" )) or ( $_POST["regbut"] != "$def_reg" ) )

{
    
if ($error_on == 1) {

    $def_message_error=$error_reg;
    
include ( "./includes/error_page.php" );
    
}

main_table_top ($def_reg);
    
$template = new Template;

$template->set_file('register.tpl');

$template->replace("bgcolor", $def_form_back_color);

    require 'includes/components/category_reg.php'; // Подключаем вывод списка категорий

$template->replace("company", $def_company);
$template->replace("rezult_company", $firmname);

$template->replace("description", $def_description);
$template->replace("rezult_description", $business);

$template->replace("keywords", $def_keywords);
$template->replace("rezult_keywords", $keywords);

    require 'includes/components/location_reg.php'; // Подключаем вывод списка категорий

$template->replace("address", $def_address);
$template->replace("rezult_address", $address);

$template->replace("zip", $def_zip);
$template->replace("rezult_zip", $zip);

$template->replace("phone", $def_phone);
$template->replace("rezult_phone", $phone);

$template->replace("fax", $def_fax);
$template->replace("rezult_fax", $fax);

$template->replace("mobile", $def_mobile);
$template->replace("rezult_mobile", $mobile);

$template->replace("icq", $def_icq);
$template->replace("rezult_icq", $icq);

$template->replace("manager", $def_manager);
$template->replace("rezult_manager", $manager);

$template->replace("www", $def_webpage);
$template->replace("rezult_www", $www);

$template->replace("twitter", $def_twitter);
$template->replace("rezult_twitter", $twitter);

$template->replace("facebook", $def_facebook);
$template->replace("rezult_facebook", $facebook);

$template->replace("vk", $def_vk);
$template->replace("rezult_vk", $vk);

$template->replace("odnoklassniki", $def_odnoklassniki);
$template->replace("rezult_odnoklassniki", $odnoklassniki);

if ($def_reserved_1_enabled == "YES") {
    $template->replace("reserved_1", $def_reserved_1_name);
    $template->replace("rezult_reserved_1", $reserved_1);
}

if ($def_reserved_2_enabled == "YES") {
    $template->replace("reserved_2", $def_reserved_2_name);
    $template->replace("rezult_reserved_2", $reserved_2);
}

if ($def_reserved_3_enabled == "YES") {
    $template->replace("reserved_3", $def_reserved_3_name);
    $template->replace("rezult_reserved_3", $reserved_3);
}

if ($def_security_enable == "YES") {

$template->replace("security_img", "<img src=\"security.php?$rand\" />");
$template->replace("security", $def_security);

}

$template->replace("mail", $def_email);
$template->replace("rezult_mail", $mail);

$template->replace("domen", $def_domen);
$template->replace("rezult_domen", $domen);

$template->replace("login", $def_login);
$template->replace("rezult_login", $login);

$template->replace("pass", $def_pass);
$template->replace("pass_repeat", "$def_pass $def_repeat");

$template->replace("reg_buttion", $def_reg);

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("catalog", str_replace('http://', '', $def_mainlocation));
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

main_table_bottom();

}

include ( "./template/$def_template/footer.php" );

?>
