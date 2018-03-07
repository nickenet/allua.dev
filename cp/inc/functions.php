<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: functions.php
-----------------------------------------------------
 Назначение: Дополнительные функции
=====================================================
*/

// Авторизация
function check_login_cp($admin,$url)

{

        global $db;
	global $db_admin;

 if (!$_SERVER['HTTP_REFERER']) { header('Location: index.php'); die( "Hacking attempt!" ); exit; }

 if (!isset($_SESSION["adm_ident"])) { header('Location: index.php'); die( "Hacking attempt!" ); exit; }

 if (!isset($_SESSION['admin_login'])) { header('Location: index.php'); die( "Hacking attempt!" ); exit; }

$sql	= 'SELECT * FROM ' . $db_admin . ' '
		. 'WHERE login="' . $_SESSION['admin_login'] . '"';
$r_auth = $db->query($sql);
$f_auth = $db->fetcharray($r_auth);

if ($f_auth['login'] == $_SESSION['admin_login']
	and $f_auth['password'] == $_SESSION['admin_pass']
	and mysql_num_rows($r_auth) == '1') 
{
    mysql_free_result($r_auth);
    $_SESSION['name_admin'] = $f_auth['name'];
    $_SESSION['admin_login'] = $f_auth['login'];
    $_SESSION['icq_admin'] = $f_auth['icq'];
    $_SESSION['phone_admin'] = $f_auth['phone'];
    $_SESSION['adress_admin'] = $f_auth['adress'];
    $menu_start=explode("#", $f_auth['menu']);
    $_SESSION['menu'] = $menu_start[1];
    $_SESSION['menu_punkt'] = $menu_start[0];
    $_SESSION['num_admin'] = $f_auth['num'];
}
 else

{
	$_SESSION = array();
        $_SESSION ['url'] = $url;
	header('Location: index.php');
	die();
	exit;
	return;
}

}

// Сообщения
function msg_text($with_table,$message_title,$message_text)

{

echo <<<HTML

<br /><br />
<table width="$with_table" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="8"><img src="images/msg_01.gif" width="8" height="6"></td>
    <td background="images/msg_02.gif"><img src="images/msg_02.gif" width="2" height="6"></td>
    <td width="8"><img src="images/msg_03.gif" width="8" height="6"></td>
  </tr>
  <tr>
    <td width="8" background="images/msg_04.gif">&nbsp;</td>
    <td bgcolor="#FFFBD5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20"><img src="images/msg_ico.png" width="16" height="16"></td>
        <td height="20" class="red_txt" align="left">$message_title</td>
      </tr>
      <tr>
        <td width="20">&nbsp;</td>
        <td align="left">$message_text</td>
      </tr>
    </table></td>
    <td width="8" background="images/msg_05.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="8"><img src="images/msg_06.gif" width="8" height="7"></td>
    <td background="images/msg_07.gif"><img src="images/msg_07.gif" width="4" height="7"></td>
    <td width="8"><img src="images/msg_08.gif" width="8" height="7"></td>
  </tr>
</table>
<br />

HTML;

}

// Очистить кэш
function empty_cache($file_cache)

{

$f = fopen($file_cache,"w");
fclose($f);

}

// Проверка ТП
function ifType_info ($flag, $field)

{

	$valvar =  "def_".$flag."_".$field;

	include (".././conf/memberships.php");

	return $$valvar;

}

// Запись логов
function logsto($admin_logs)

{

	global $db;
	global $db_log;

	$date = date("Y-m-d");

	$time_hour = date("H");
	$time_min = date("i");
	$time_sec = date("s");

	$date_day = date("d");
	$date_month = date("m");
	$date_year = date("Y");

	$ip=$_SERVER["REMOTE_ADDR"];

	$log="$time_hour:$time_min:$time_sec  $date_year/$date_month/$date_day - [$_SESSION[admin_login], $ip] - $admin_logs";

	$db->query ("INSERT INTO $db_log (log) VALUES ('$log')") or die ("mySQL error!");

}

// Обработка текста с редактора
function post_to_shortfull ($str_full_short) {

    if( function_exists( "get_magic_quotes_gpc" ) && get_magic_quotes_gpc() ) $str_full_short = stripslashes( $str_full_short );

    $str_full_short = preg_replace( "#\{include#i", "&#123;include", $str_full_short );
    $str_full_short = preg_replace( "#<iframe#i", "&lt;iframe", $str_full_short );
    $str_full_short = preg_replace( "#<script#i", "&lt;script", $str_full_short );
    $str_full_short = str_replace( "<?", "&lt;?", $str_full_short );
    $str_full_short = str_replace( "?>", "?&gt;", $str_full_short );

    $str_full_short = addslashes( $str_full_short );

    $str_full_short=trim($str_full_short);

    return $str_full_short;
}

?>