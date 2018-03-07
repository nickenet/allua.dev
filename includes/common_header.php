<?php

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ( $def_gzip == 'YES' && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false && extension_loaded('zlib') )

{

@	ob_start("ob_gzhandler");
@	ob_implicit_flush(0);
@	header("Content-Encoding: gzip");

}

header("Expires: Mon, 15 apr 2009 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

$timing_start = explode(' ', microtime());

?>