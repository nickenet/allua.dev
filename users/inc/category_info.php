<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_info.php
-----------------------------------------------------
 Назначение: Вывод списка категорий при редактировании
=====================================================
*/

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

?>

<? echo $def_category; ?>: <font color="red">*</font><br />

  <SELECT NAME="category[]" multiple style="font-size:10px; width:417px; height:150px;">

<?
///////////
$selectcat=0; $selectsubcat=0;
//////////
$category_list = explode(":", $f[category]);

$re = $db->query  ( "select * from $db_category order by category" ) or die (mysql_error());
$results_amount1=mysql_num_rows($re);

for($i=0;$i<$results_amount1;$i++)

{
	$fe=$db->fetcharray ($re);

	$ree = $db->query  ( "select * from $db_subcategory where catsel=$fe[selector] order by subcategory");
	$results_amount2=mysql_num_rows($ree);

	if ($results_amount2 == 0) $results_amount2=1;

	for($j=0;$j<$results_amount2;$j++)

	{
		$fee=$db->fetcharray ($ree);

		$reee = $db->query  ( "select * from $db_subsubcategory where catsel=$fe[selector] and catsubsel = $fee[catsubsel] order by subsubcategory");
		@        $results_amount3=mysql_num_rows($reee);

		if (($results_amount2 == 0) and ($results_amount3 == 0)) $results_amount3=1;
		if (($results_amount2 != 0) and ($results_amount3 == 0)) $results_amount3=1;

		for($k=0;$k<$results_amount3;$k++)

		{
			@         $feee=$db->fetcharray ($reee);

			$found= "0";

			for ( $cat1=0;$cat1<count($category_list);$cat1++)

			{
				if (!isset($fee[catsubsel])) $fee[catsubsel]=0;
				if (!isset($feee[catsubsubsel])) $feee[catsubsubsel]=0;

				if ($category_list[$cat1] == "$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]")

				{
					$found = "1";
				}
			}
////////////////////////////////////
if ($selectcat != $fe[selector] and ( $feee[catsubsubsel] != 0 or $fee[catsubsel] != 0) ) {
echo "<optgroup label='$fe[category]' class='catXR'>";
$selectcat=$fe[selector];
}
if ( $selectsubcat != $fee[catsubsel] and $feee[catsubsubsel] != 0 and $fee[catsubsel] != 0 ) {
echo "<optgroup label='$fee[subcategory]' class='subXR'>";
$selectsubcat=$fee[catsubsel];
}
///////////////////////////////////
			if ($found == "1") {

				if (($feee[catsubsubsel] != 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\" SELECTED>$feee[subsubcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#0\" SELECTED>$fee[subcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] == 0))
				echo "<OPTION class='mainXR' VALUE=\"$fe[selector]#0#0\" SELECTED>$fe[category]</OPTION>";

			}

			else

			{

				if (($feee[catsubsubsel] != 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\">$feee[subsubcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#0\">$fee[subcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] == 0))
				echo "<OPTION class='mainXR' VALUE=\"$fe[selector]#0#0\">$fe[category]</OPTION>";

			}

		}

	}
}

@       $db->freeresult  ( $re );
@       $db->freeresult  ( $ree );
@       $db->freeresult  ( $reee );

?>

</SELECT>
