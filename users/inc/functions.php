<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: functions.php
-----------------------------------------------------
 Назначение: Основные функции
=====================================================
*/

function mytarif ($tarif)

{
	global $def_D;
	global $def_C;
	global $def_B;
	global $def_A;

	switch ($tarif) {
		case "A": echo "$def_A"; break;
		case "B": echo "$def_B"; break;
		case "C": echo "$def_C"; break;
	default: echo "$def_D";
	}
}

function make_seed() { 
    list($usec, $sec) = explode (' ', microtime()); 
    return (float) $sec + ((float) $usec * 100000); 
} 

function update_categories_user ($oldflag, $flag, $oldcategories, $newcategories, $section)

{

	global $db_category;
	global $db_subcategory;
	global $db_subsubcategory;

	if ( ( ( $def_onlypaid == "YES" ) and ($oldflag != "D") ) or ( $def_onlypaid != "YES" ) )


	{

		$category = explode (":", $oldcategories);

		for ($index = 0; $index < count ( $category ); $index++)

		{


			$new_cat = explode ("#", $category[$index]);

			if ( $new_cat[0] != $prev_cat )

			mysql_query ("UPDATE $db_category SET fcounter = fcounter-1 where selector=$new_cat[0]");

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

			mysql_query ("UPDATE $db_subcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]");

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

			mysql_query ("UPDATE $db_subsubcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]");

			$prev_cat=$new_cat[0];
			$prev_subcat=$new_cat[1];

		}

	}

unset($prev_cat);
unset($prev_subcat);

	$index_category = 1;

	for ($index = 0; $index < count ( $newcategories ); $index++)

	{

		if ($newcategories[$index] != "") {

			$category_index[$index_category] = $newcategories[$index];$index_category++;


			if ( ( ( $def_onlypaid == "YES" ) and ( $flag != "D" ) ) or ( $def_onlypaid != "YES" ) )

			{


				$new_cat = explode ("#", $newcategories[$index]);

				if ($new_cat[0] != $prev_cat)

				mysql_query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat[0]");

				if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

				mysql_query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]");

				if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

				mysql_query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]");

			}

			$prev_cat=$new_cat[0];
			$prev_subcat=$new_cat[1];

		}

	}

	@ $category = join(":", $category_index);

	return $category;

}

function ifEnabled_user ($flag, $field)

{

	// Generating a membership variable based
	// on the flag (membership) and field name
	// passed to the function

	$fieldvar =  "def_".$flag."_".$field;

	include (".././conf/memberships.php");

	// If the field is enabled we return True

	if ($$fieldvar == "YES")
	return True;
	else
	return False;

}

function ifType_info ($flag, $field)

{

	$valvar =  "def_".$flag."_".$field;

	include (".././conf/memberships.php");

	return $$valvar;

}

function logi($kID,$kFlag,$kD)
{
	global $def_file_log;

	$f = fopen($def_file_log, 'a');
	fwrite($f, date('Y-m-d H:i:s').';'.$kID.';'.$kFlag.';'.$kD."\r\n");
	fclose($f);

}

?>