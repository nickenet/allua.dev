<?php

/*

Задать город

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<form name="search" action="<? echo $_SERVER[REQUEST_URI]; ?>" method="post">
    <input type="search"  name="Smycity" class="input-city" value="<? echo $_SESSION['smycity']; ?>" placeholder="Укажите город" /><a href="?city=del" class="input-city_del">X</a>
</form>