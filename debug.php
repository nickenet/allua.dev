<?php 

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: debug.php
-----------------------------------------------------
 Назначение: Отладочная информация
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($def_debug == "YES")

{
	$timing_stop = explode(' ', microtime());
	$timings = $timing_stop[0] - $timing_start[0];
	$timings+= $timing_stop[1] - $timing_start[1];
	$timings = round($timings, 3);

	if ( $def_gzip == 'YES' && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false && extension_loaded('zlib') )

	$gzip = "Enabled";

	else

	$gzip = "Disabled";

	echo "
  <font color=#AAAAAA>
    This Page Took <b>$timings</b> secs To Load, Current Template - \"<b>$def_template</b>\", Language - \"<b>$lang</b>\".<br />
    GZip Compression <b>" . $gzip . "</b>, <b>" . $db->counter . "</b> SQL Queries Executed, Took " . $db->timecounter ." secs ( Average " . @ round (($db->timecounter / $db->counter), 3) . " secs )
  </font>
 <br /> <br />";

}

?>