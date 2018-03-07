<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: csv.php
-----------------------------------------------------
 Назначение: CSV Export
=====================================================
*/

session_start();

include("./defaults.php");

$r = $db->query ("select * from $db_admin where login='$_SESSION[admin_login]'");
$f = $db->fetcharray ($r);

if (($f["login"] == $_SESSION["admin_login"]) and ($f["password"] == $_SESSION["admin_pass"]) and (mysql_num_rows($r) == '1'))

{

	$sql = "select * from $db_users";

	$r= $db->query ( "$sql" );


	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
		$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	} else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
		$HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	} else if (!isset($HTTP_USER_AGENT)) {
		$HTTP_USER_AGENT = '';
	}

	// 1. Platform
	if (strstr($HTTP_USER_AGENT, 'Win')) {
		define('PMA_USR_OS', 'Win');
	} else if (strstr($HTTP_USER_AGENT, 'Mac')) {
		define('PMA_USR_OS', 'Mac');
	} else if (strstr($HTTP_USER_AGENT, 'Linux')) {
		define('PMA_USR_OS', 'Linux');
	} else if (strstr($HTTP_USER_AGENT, 'Unix')) {
		define('PMA_USR_OS', 'Unix');
	} else if (strstr($HTTP_USER_AGENT, 'OS/2')) {
		define('PMA_USR_OS', 'OS/2');
	} else {
		define('PMA_USR_OS', 'Other');
	}

	// 2. browser and version
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

	if ( preg_match('#Opera(/| )([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[2]);
	  define('PMA_USR_BROWSER_AGENT', 'OPERA');
	} 
	elseif ( preg_match('#MSIE ([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'IE');
	} 
	elseif ( preg_match('#OmniWeb/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
	} 
	elseif ( preg_match('#Mozilla/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'MOZILLA');
	} 
	elseif ( preg_match('#Konqueror/([0-9]\.[0-9]{1,2})#', $HTTP_USER_AGENT, $log_version) ) 
	{
	  define('PMA_USR_BROWSER_VER', $log_version[1]);
	  define('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
	} 
	else 
	{
	  define('PMA_USR_BROWSER_VER', 0);
	  define('PMA_USR_BROWSER_AGENT', 'OTHER');
	}


	// Send headers
	header('Content-Type: application/octetstream');

	if (PMA_USR_BROWSER_AGENT == 'IE') {
		header('Content-Disposition: inline; filename="' . $_GET[file] . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="' . $_GET[file] . '"');
		header('Expires: 0');
		header('Pragma: no-cache');
	}


	echo "Listing Unique ID;Company Name;Number of Listing Reviews;Number of Messages Sent to the Listing;Number of Website Clicks;Banners Exposures;Banners Clicks;Products Reviews;Statistics Creation Date;\r\n";

	$date=date ("m-d-Y");

	for ($i=0;$i<$db->numrows($r);$i++)

	{

		$f=$db->fetcharray($r);

		$firmname= unHTML($f[firmname]);

		echo "$f[selector];$firmname;$f[counter];$f[mailcounter];$f[webcounter];$f[banner_show];$f[banner_click];$f[price_show];$date;\r\n";

	}
	$db->close();
	exit;

}

?>