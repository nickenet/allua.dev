<?php

die ('stop');

ini_set ('error_reporting', E_ALL & ~E_NOTICE);

include("./defaults.php");

$db->query ("UPDATE $db_category SET fcounter=0");
$db->query ("UPDATE $db_category SET sccounter=0");
$db->query ("UPDATE $db_category SET ssccounter=0");
$db->query ("UPDATE $db_subcategory SET fcounter=0");
$db->query ("UPDATE $db_subcategory SET ssccounter=0");
$db->query ("UPDATE $db_subsubcategory SET fcounter=0");

$raz1=$db->query ("SELECT * FROM $db_category");

for ($xx=0;$xx<mysql_num_rows($raz1);$xx++)

{

	$faz1=$db->fetcharray ($raz1);

	$raz2=$db->query ("SELECT * FROM $db_subcategory where catsel=$faz1[selector]");

	$db->query ("UPDATE $db_category SET sccounter=".mysql_num_rows($raz2)." where selector=$faz1[selector]");
	echo "CATEGORY SCCOUNTER $faz1[selector] UPDATED TO ".mysql_num_rows($raz2)."<br>";

	$raz5=$db->query ("SELECT * FROM $db_subsubcategory where catsel=$faz1[selector]");
	$db->query ("UPDATE $db_category SET ssccounter=".mysql_num_rows($raz5)." where selector=$faz1[selector]");
	echo "CATEGORY SSCCOUNTER $faz1[selector] UPDATED TO ".mysql_num_rows($raz5)."<br>";

	for ($xx1=0;$xx1<mysql_num_rows($raz2);$xx1++)

	{

		$faz2=$db->fetcharray ($raz2);
		$raz3=$db->query ("SELECT * FROM $db_subsubcategory where catsel=$faz1[selector] and catsubsel=$faz2[catsubsel]");

		$db->query ("UPDATE $db_subcategory SET ssccounter=".mysql_num_rows($raz3)." where catsel=$faz1[selector] and catsubsel=$faz2[catsubsel]");
		echo "SUBCATEGORY SSCCOUNTER $faz2[catsubsel] UPDATED TO ".mysql_num_rows($raz3)."<br>";

	}

}





if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$raz=$db->query ("SELECT * FROM $db_users where firmstate='on' $hide_d");


for($zz=0;$zz<mysql_num_rows($raz);$zz++)

{

	$f=$db->fetcharray ($raz);

	$category = explode (":", $f[category]);

	$prev_cat1="";
	$prev_subcat1="";

	for ($index1 = 0; $index1 < count ( $category ); $index1++)

	{

		echo "UPDATED CATEGORY ($category[$index1]) FOR $f[firmname] ID ($f[selector]), FLAG $f[flag]<br>";

		$new_cat1 = explode ("#", $category[$index1]);

		if ($new_cat1[0] != $prev_cat1)

		{

			$db->query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat1[0]") or die (mysql_error());
			echo "UPDATED CAT + 1 WHERE selector=$new_cat1[0]<br>";
		}
		if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[1] != $prev_subcat1))
		{
			$db->query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1]") or die (mysql_error());
			echo "UPDATED SUBCAT + 1 WHERE catsel=$new_cat1[0] and catsubsel=$new_cat1[1]<br>";
		}
		if (($new_cat1[1] != "") and ($new_cat1[1] != "0") and ($new_cat1[2] != "") and ($new_cat1[2] != "0"))
		{
			$db->query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat1[0] and catsubsel=$new_cat1[1] and catsubsubsel=$new_cat1[2]") or die (mysql_error());
			echo "UPDATED SUBSUBCAT + 1 WHERE catsel=$new_cat1[0] and catsubsel=$new_cat1[1] and catsubsubsel=$new_cat1[2]<br>";
		}
		$prev_cat1=$new_cat1[0];
		$prev_subcat1=$new_cat1[1];

	}
}

$db->close();
exit;

?>