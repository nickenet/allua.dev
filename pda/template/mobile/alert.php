<?php

/*

Шаблон вывода сообщений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if (isset($alert_info)) echo '<div class="'.$class_alert.'">'.$alert_info.'</div>';

?>
