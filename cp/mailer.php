<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: mailer.php
-----------------------------------------------------
 Назначение: Рассылка сообщений
=====================================================
*/

@set_time_limit(20*60);

session_start();

require_once './defaults.php';

$help_section = (string)$mailer_help;

$title_cp = 'Рассылка - ';
$speedbar = ' | <a href="mailer.php">Рассылка сообщений</a>';

check_login_cp('3_6','mailer.php');

require_once 'template/header.php';

table_item_top ($def_admin_mailer_button,'email.png');

if ($_GET["REQ"] == "send") {

		@ini_set( 'max_execution_time', 0 );
		@set_time_limit();

                $query = "SELECT off_mailer,selector, domen, domen1, mail, off_mailer, firmname, manager, login, tmail FROM $db_users WHERE firmstate = 'on' and mail !='' ";

		if ($_POST[location] != "ANY") { $location_sql=intval($_POST['location']);
		$query.= " AND location = '$location_sql' "; }

		if ($_POST[state] != "ANY") { $state_sql=intval($_POST['state']);
		$query.= " AND state = '$state_sql' "; }

		if ($_POST[flag] != "ANY") { $flag_sql=htmlspecialchars($_POST['flag'],ENT_QUOTES,$def_charset);
		$query.= " AND flag = '$flag_sql' "; }

                if ($_POST['tmail'] == "ok") $query.= " AND tmail = '1' ";
                if ($_POST['tmail'] == "no") $query.= " AND tmail != '1' ";
                if ($_POST['tcase'] == "ok") $query.= " AND tcase = '1' ";
                if ($_POST['tcase'] == "no") $query.= " AND tcase != '1' ";
                if ($_POST['pole_pust'] != "off") { 

			$pole_pust=safeHTML ($_POST['pole_pust']);
		
				if ($pole_pust=="address") $query.= " AND address = '' ";
				if ($pole_pust=="phone") $query.= " AND phone = '' ";
				if ($pole_pust=="mobile") $query.= " AND mobile = '' ";
				if ($pole_pust=="fax") $query.= " AND fax = '' ";
				if ($pole_pust=="manager") $query.= " AND manager = '' ";
				if ($pole_pust=="map") $query.= " AND map = '' ";
				if ($pole_pust=="www") $query.= " AND www = '' ";

 		}

		if ($_POST[category] != "ANY") { $category_sql=safeHTML($_POST['category']);
		$query.= " AND ((category LIKE '$category_sql') or (category LIKE '%:$category_sql:%') or (category LIKE '%:$category_sql') or (category LIKE '$category_sql:%')) "; }

                $id_ot=intval($_POST['id_ot']);
                $id_do=intval($_POST['id_do']);

                $where_sql="";
                if (($id_ot>0) and ($id_do>0)) $where_sql=" and (selector between $id_ot and $id_do ) ";
                if (($id_ot>0) and ($id_do==0)) $where_sql=" and selector > $id_ot ";
                if (($id_ot==0) and ($id_do>0)) $where_sql=" and selector < $id_do ";
                $query .= $where_sql;

		$maildb = $db->query ("$query") or die ("mySQL error!");

		$res = mysql_num_rows($maildb);

		$mails = htmlspecialchars($_POST['email'],ENT_QUOTES,$def_charset);
                $firmnames = "копия";
                $managers = $_SESSION['admin_login'].'(копия)';
                $logins = $_SESSION['admin_login'].'(копия)';
                
		if ($res > 0)

		{
			$subject=safeHTML($_POST['subject']);
			$subject = stripcslashes($subject);

			$from = htmlspecialchars($_POST['email'],ENT_QUOTES,$def_charset);

                        $max_pisem=intval($_POST['max_pisem']);
                        if ($max_pisem == 0) $max_pisem=$res;

                        $mail_res=0;
			$mail_form_c=0;

$report='
+--------------------------------------------------
| Рассылка "'.$subject.'"
| Дата рассылки: '.date('d.m.Y').'
| E-mail: '.$from.'
| Сформированно данных с запроса: '.$max_pisem.'
+--------------------------------------------------
';
                        
			for ($xxx = 0; $xxx < $max_pisem; $xxx++)

			{
                            $zzz = $db->fetcharray ($maildb);
                                        $text=post_to_shortfull($_POST['text']);
                                        $message = stripcslashes($text);
                                        $message = str_replace("*title*", $def_title, $message);
                                        $message = str_replace("*dir_to_main*", $def_mainlocation, $message);
                                        $firmname = str_replace("&quot;", '"', $zzz['firmname']);
                                        $firmname = str_replace("&amp;", '&', $firmname);
                                        $message = str_replace("*firmname*",$firmname, $message);
                                        if ($zzz['manager']!='') $managers = $zzz['manager']; else $managers = htmlspecialchars ($_POST['manager_replace'],ENT_NOQUOTES,$def_charset);
                                        $message = str_replace("*manager*", $managers, $message);
                                        $message = str_replace("*login*", $zzz['login'], $message);
                                        $message = str_replace("*mail*", $zzz['mail'], $message);
                                        $message = str_replace("*id*", $zzz['selector'], $message);
                                        $message = str_replace("*domen*", $zzz['domen'], $message);
                                        if ($zzz['tmail']==1) $status_mail_ok='+'; else $status_mail_ok='-';
                                        if ($zzz['off_mailer']==1) $mailer_off='отписан'; else $mailer_off='+';                                        
                                        $report .= date('H.i').'|'.$zzz['selector'].'|'.$zzz['mail'].'|'.$status_mail_ok.'|'.$mailer_off.'|'.$firmname."\n";
					
					$mail_form_c++;
					
									
					if ($_POST['off_mailer']=="on")  {

						$mail_res++;

	                                        if ($_POST['all_report']!=1) mail($zzz['mail'],$subject,$message,"From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n");                                        

					} else {

					if ($zzz['off_mailer']!=1) { $mail_res++;
						if ($_POST['all_report']!=1) mail($zzz['mail'],$subject,$message,"From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n"); }

					}					
					
			}

                                        // Копия админу
                                        $text=post_to_shortfull($_POST['text']);
                                        $message = stripcslashes($text);
                                        $message = str_replace("*title*", $def_title, $message);
                                        $message = str_replace("*dir_to_main*", $def_mainlocation, $message);
                                        $firmname = str_replace("&quot;", '"', 'КОПИЯ');
                                        $firmname = str_replace("&amp;", '&', $firmname);
                                        $message = str_replace("*firmname*",$firmname, $message);
                                        $managers = $_SESSION['admin_login'].'(копия)';
                                        $message = str_replace("*manager*", $managers, $message);
                                        $message = str_replace("*login*", $_SESSION['admin_login'].'(копия)', $message);
                                        $message = str_replace("*mail*", htmlspecialchars($_POST['email'],ENT_QUOTES,$def_charset), $message);
                                        $message = str_replace("*id*", "---копия", $message);
                                        $message = str_replace("*domen*", "---копия", $message);
                                        $report .= date('H.i').'|'.htmlspecialchars($_POST['email'],ENT_QUOTES,$def_charset).'|'.$firmname."\n";
                                        if ($_POST['all_report']!=1) mail($mails,$subject,$message,"From: $from\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $from\r\n"."MIME-Version: 1.0\n"."X-Sender: $from\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n");

$report .= '
+--------------------------------------------------
Сформировано - '.$mail_form_c.' сообщений
Отправлено - '.$mail_res.' сообщений
+--------------------------------------------------
| Шаблон с текстом рассылки
+--------------------------------------------------
'.stripcslashes(post_to_shortfull($_POST['text'])).'
';

$txt_report='';
if ($_POST['txt_report']==1) {

        $file_mailer=date('d.m.Y.H.i').'-'.rewrite($subject).'.txt';

        $con_file = fopen("../myfiles/$file_mailer", "w+") or die("Извините, но невозможно записать в файл. Проверьте правильность проставленного CHMOD для папки Upload!");
        fwrite($con_file, $report);
        fclose($con_file);

        $txt_report=' <a target="_blank" href="../myfiles/'.$file_mailer.'">Скачать</a> отчет по рассылке';

}
                        if ($_POST['all_report']!=1) { msg_text('80%',$def_admin_message_ok,'<b>'.$mail_res.'</b> сообщений отправленно.'.$txt_report);

                        logsto("Выполнена рассылка. Отправлено <b>$mail_res</b> сообщений."); }

                        else msg_text('80%',$def_admin_message_ok,$txt_report);

			echo '<br />';
		}

                else

                msg_text('80%',$def_admin_message_error,'Сообщения не отправленны.');

                echo '<br />';
}

table_fdata_top ('Заполните форму для отправки сообщений');

include ('../includes/editor/tiny.php');

?>

<style type="text/css">
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>

<?

echo '
<form action="mailer.php?REQ=send" method="post" enctype="multipart/form-data">
 <table width="90%" align="center">
  <tr>
   <td valign="top" align="right">
    '.$def_to.':&nbsp;&nbsp;</td><td align="left">
  <SELECT NAME="category" style="width:413px;">';

	echo '<OPTION VALUE="ANY">' .$def_any_category;

	$r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
	$results_amount = mysql_num_rows ( $r );

	for ( $i=0; $i < $results_amount; $i++ )

	{
		$f = $db->fetcharray  ( $r );

		$ra = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsel=$f[selector] ORDER BY subcategory" );
		$results_amount2 = mysql_num_rows ( $ra );

		if ( ($results_amount2 == 0) ) $results_amount2 = 1;

		for ( $j=0; $j < $results_amount2; $j++)

		{
			$fa = $db->fetcharray  ( $ra );
			$raa = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel=$f[selector] and catsubsel=$fa[catsubsel] ORDER BY subsubcategory" );
			@ $results_amount3 = mysql_num_rows ( $raa );

			if (($results_amount3 == 0) and ($results_amount2 == 0)) $results_amount3 = 1;
			if (($results_amount3 == 0) and ($results_amount2 != 0)) $results_amount3 = 1;

			for ( $k=0; $k < $results_amount3; $k++ )

			{
				@      $faa = $db->fetcharray  ( $raa );

				if ( ( !isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

				echo '<OPTION VALUE="'.$f[selector].'#0#0">'.$f[category];

				if ( ( isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

				echo '<OPTION VALUE="'.$f[selector].'#'.$fa[catsubsel].'#0">'.$f[category].' :: '.$fa[subcategory];

				if ( ( isset($fa[catsubsel]) ) and ( isset($faa[catsubsubsel]) ) )

				echo '<OPTION VALUE="'.$f[selector].'#'.$fa[catsubsel].'#'.$faa[catsubsubsel].'">'.$f[category].' :: '.$fa[subcategory].' :: '.$faa[subsubcategory];

			}

		}

	}

	@  mysql_free_result ( $r );
	@  mysql_free_result ( $ra );
	@  mysql_free_result ( $raa );

	echo '</SELECT>';
	echo ' </td></tr>
  <tr>
   <td valign=top align="left">
    </td><td align="left">
     <SELECT NAME="location" style="width:412px;">';

	if ( $def_country_allow == "YES" )

	echo '<OPTION VALUE="ANY">'.$def_any_country;

	else

	echo '<OPTION VALUE="ANY">'.$def_any_city;

	$r = $db->query  ( "SELECT * FROM $db_location ORDER BY location" );
	$results_amount = mysql_num_rows ( $r );

	for ( $i=0; $i < $results_amount; $i++ )

	{
		$f = $db->fetcharray  ( $r );
		echo '<OPTION VALUE="'.$f[locationselector].'">'.$f[location];
	}

	mysql_free_result ( $r );
	echo '</SELECT>';
	echo '</td></tr>
  <tr>
   <td valign="top" align="left">
    </td><td align="left">';

	if ( $def_states_allow == "YES" )

	{
		echo '<SELECT NAME="state" style="width:412px;">';

		echo '<OPTION VALUE="ANY">'.$def_any_state;

		$r = $db->query  ( "SELECT * FROM $db_states ORDER BY state" );
		$results_amount = mysql_num_rows ( $r );

		for ( $i=0; $i < $results_amount; $i++)

		{
			$f = $db->fetcharray  ( $r );
			echo '<OPTION VALUE="'.$f[stateselector].'">'.$f[state];
		}

		mysql_free_result ( $r );
		echo '</SELECT>';
	}
	echo '</td></tr>';
	echo '</td></tr>
  <tr>
   <td valign="top" align="left">
    </td><td align="left">';

	echo '<SELECT NAME="flag" style="width:412px;">';

        echo '<OPTION VALUE="ANY">'.$def_any_membership;

	if ($def_A_enable == "YES") echo '<OPTION VALUE="A">'.$def_A;
	if ($def_B_enable == "YES") echo '<OPTION VALUE="B">'.$def_B;
	if ($def_C_enable == "YES") echo '<OPTION VALUE="C">'.$def_C;
        
        echo '<OPTION VALUE="D">'.$def_D;

	echo '</SELECT></td></tr>';

        echo '
  <tr>
   <td valign="top" align="left"></td>
    <td align="left">';

	echo '<SELECT NAME="tmail" style="width:412px;">';

        echo '<OPTION VALUE="all">'.$def_mail_status_all;

	echo '<OPTION VALUE="ok">'.$def_mail_status_ok;
        echo '<OPTION VALUE="no">'.$def_mail_status_no;

	echo '</SELECT></td></tr>';

        echo '
  <tr>
   <td valign="top" align="left"></td>
    <td align="left">';

	echo '<SELECT NAME="tcase" style="width:412px;">';

        echo '<OPTION VALUE="all">'.$def_case_status_all;

	echo '<OPTION VALUE="ok">'.$def_case_status_ok;
        echo '<OPTION VALUE="no">'.$def_case_status_no;

	echo '</SELECT></td></tr>';

        echo '
  <tr>
   <td valign="top" align="left"></td>
    <td align="left">';

	echo '<SELECT NAME="off_mailer" style="width:412px;">';

        echo '<OPTION VALUE="off">Не отправлять тем, кто отписался от рассылки';
	echo '<OPTION VALUE="on">Отправлять всем, кто даже отписался от рассылки';

	echo '</SELECT><br /><br /></td></tr>';

        $template_mail = file_get_contents ('../template/' . $def_template . '/mail/mailer.tpl');

	echo '
  <tr>
   <td valign="top" align="right">
        ID компаний:&nbsp;&nbsp;
   </td>
   <td align="left">
        от <input type="text" name="id_ot" style="width: 40px;" /> до <input type="text" name="id_do" style="width: 40px;" />
   </td>
  </tr>
  <tr>
   <td valign="top" align="right">
        Поле пустое:&nbsp;&nbsp;
   </td>
   <td align="left">
	<SELECT NAME="pole_pust" style="width:212px;">
		<option value="off" selected>-------</option>
		<option value="address">Адрес</option>
		<option value="phone">Телефон</option>
		<option value="mobile">Мобильный</option>
		<option value="manager">Контактное лицо</option>
		<option value="map">Местоположение на карте</option>
		<option value="www">Сайт</option>
	</SELECT>       
 укажите имя незаполненного поля в базе данных<hr />
   </td>
  </tr>
  <tr>
   <td valign="top" align="right">
        E-mail адрес:&nbsp;&nbsp;
   </td>
   <td align="left">
        <input type="text" size="66" maxwidth="256" name="email" value="'.$def_adminmail.'" />
   </td>
  </tr>
  <tr>
   <td valign="top" align="right">
        '.$def_subject.':&nbsp;&nbsp;
   </td>
   <td align="left">
        <input type="text" size="66" maxwidth="256" name="subject" />
   </td>
  </tr>
  <tr>
   <td valign="top" align="right">
        '.$def_message.':&nbsp;&nbsp;
   </td>
   <td align="left">
        <textarea id="area_full" name="text">'.$template_mail.'</textarea><hr />
   </td>
  </tr>
  <tr>
   <td valign="top" align="right">Разрешенные теги к использованию:&nbsp;&nbsp;</td>
  <td align="left">
    <font color="#990000"><b>*firmname*</b></font> - название компании<br />
    <font color="#990000"><b>*manager*</b></font> - контактное лицо (в случае отсутствия заменить <input type="text" name="manager_replace" style="width: 200px;" value="Клиент нашего каталога" />)<br />
    <font color="#990000"><b>*login*</b></font> - логин клиента <br />
    <font color="#990000"><b>*mail*</b></font> - e-mail клиента <br />
    <font color="#990000"><b>*id*</b></font> - id компании в каталоге <br />
    <font color="#990000"><b>*domen*</b></font> - имя социальной странички компании в каталоге <br />
    <font color="#990000"><b>*title*</b></font> - название каталога <br />
    <font color="#990000"><b>*dir_to_main*</b></font> - полный URL до Вашего каталога<br />
    <hr />
  </td>
  <tr>
   <td valign="top" align="right">Опции:&nbsp;&nbsp;</td>
  <td align="left">
    <input name="txt_report" type="checkbox" value="1" checked />Сформировать отчет<br />
    <input name="all_report" type="checkbox" value="1" />Только отчет, не отправлять письма<br />
    Не отправлять более <input type="text" name="max_pisem" style="width: 40px;" /> писем <hr />
  </td>
  <tr>
   <td valign="top" align="left"></td>
  <td align="left">
    <input type="submit" value="Отправить" border="0" />
  </td>
  </tr>
 </table>
</form><br />';
        
table_fdata_bottom();

require_once 'template/footer.php';

?>
