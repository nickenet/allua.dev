<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: search.php
-----------------------------------------------------
 Назначение: Расширенный поиск
=====================================================
*/

include ( "./defaults.php" );

$incomingline = "$def_search_adv";

include ( "./template/$def_template/header.php" );

echo '<h1 class="post-title">'.$def_search_adv.'</a></h1>';

?>

<div class="search-form">
<form name="search" action="search-3.php" method="post">
<p><? echo $def_category; ?>:
<select class="input-search" name="category">

<?

 $r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
 $results_amount = mysql_num_rows ( $r );

 echo '<option value="ANY">'.$def_search_category.'</option>';

 for ( $i=0;$i<$results_amount;$i++ ) {
 	$f = $db->fetcharray  ( $r );
 	echo '<option value="'.$f['selector'].'">'.$f['category'].'</option>';
 }

 $db->freeresult  ( $r );
?>
</select>
</p>
<p><? echo $def_company; ?>:<input class="input-search" type="text" name="firmname" /></p>
<p><? echo $def_description; ?>:<input class="input-search" type="text" name="business" /></p>
<p><? echo $def_phone; ?>:<input class="input-search" type="text" name="phone" /></p>
<p><? echo $def_mobile; ?>:<input class="input-search" type="text" name="mobile" /></p>
<p><? echo $def_address; ?>:<input class="input-search" type="text" name="address"></p>
<p><? if ( $def_country_allow == "YES" ) echo $def_country; else echo $def_city; ?>:
<select class="input-search" name="location">
<?
if ( $def_country_allow == "YES" ) echo '<option value="ANY">'.$def_search_country.'</option>';
else echo '<option value="ANY">'.$def_search_city.'</option>';

$r = $db->query  ( "SELECT * FROM $db_location ORDER BY location" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++ ) {

	$f = $db->fetcharray  ( $r );
	echo '<option value="'.$f['locationselector'].'">'.$f['location'].'</option>';
}

$db->freeresult  ( $r );

?>
</select>
</p>
<? if ($def_states_allow == "YES") { ?>
<p><? echo $def_state; ?>:
<select class="input-search" name="state" >
<?
	echo '<option value="ANY">'.$def_search_state.'</option>';

	$r = $db->query  ( "SELECT * FROM $db_states ORDER BY state" );
	$results_amount = mysql_num_rows ( $r );
	for ( $i=0; $i < $results_amount; $i++)
	{
		$f = $db->fetcharray  ( $r );
		echo '<option value="'.$f['stateselector'].'">'.$f[state].'</option>';
	}
	$db->freeresult  ( $r );
?>
</select>
</p>
<? } if ($def_country_allow == "YES") { ?>
<p><? echo $def_city; ?>:<input class="input-search" type="text" name="city" /></p>
<? } ?>
<p><? echo $def_zip; ?>:<input class="input-search" type="text" name="zip"></p>
<p><? echo $def_fax; ?>:<input class="input-search" type="text" name="fax" /></p>
<p><? echo $def_icq; ?>:<input class="input-search" type="text" name="icq" /></p>
<p><? echo $def_email; ?>:<input class="input-search" type="email" pattern="[^ @]*@[^ @]*" name="mail" /></p>
<p><? echo $def_webpage; ?>:<input class="input-search" type="url" name="www" /></p>
<? if ($def_reserved_1_enabled == "YES") { ?>
<p><? echo $def_reserved_1_name; ?>:<input class="input-search" type="text" name="reserved_1" /></p>
<? } ?>
<? if ($def_reserved_2_enabled == "YES") { ?>
<p><? echo $def_reserved_2_name; ?>:<input class="input-search" type="text" name="reserved_2" /></p>
<? } ?>
<? if ($def_reserved_3_enabled == "YES") { ?>
<p><? echo $def_reserved_3_name; ?>:<input class="input-search" type="text" name="reserved_3" /></p>
<? } ?>
<input type="submit" class="btn btn-info" name="regbut" value="<? echo "$def_search"; ?>" border="0">
</form>
</div>

<?

include ( "./template/$def_template/footer.php" );

?>