<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_offers.php
-----------------------------------------------------
 Назначение: Вывод списка категорий при редактировании
=====================================================
*/

if (empty($title_cp)) die();

echo '<tr><td  align="right">'.$def_admin_category.': &nbsp;&nbsp;</td><td  align="left">  <SELECT NAME="category[]" multiple style="width:550px; height:210px;">';

$category_list = explode(":", $f[category]);

$re = $db->query  ( "select * from $db_category order by category" ) or die (mysql_error());
$results_amount1=mysql_num_rows($re);

for($i=0;$i<$results_amount1;$i++)

{
	@     $fe=$db->fetcharray ($re);

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

			if ($found == "1") {

				if (($feee[catsubsubsel] != 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\" SELECTED>$fe[category] / $fee[subcategory] / $feee[subsubcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#0\" SELECTED>$fe[category] / $fee[subcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] == 0))
				echo "<OPTION VALUE=\"$fe[selector]#0#0\" SELECTED>$fe[category]</OPTION>";
			}

			else

			{
				if (($feee[catsubsubsel] != 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\">$fe[category] / $fee[subcategory] / $feee[subsubcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] != 0))
				echo "<OPTION VALUE=\"$fe[selector]#$fee[catsubsel]#0\">$fe[category] / $fee[subcategory]</OPTION>";

				if (($feee[catsubsubsel] == 0) and ($fee[catsubsel] == 0))
				echo "<OPTION VALUE=\"$fe[selector]#0#0\">$fe[category]</OPTION>";
			}
		}
	}
}

@      mysql_free_result ( $re );
@      mysql_free_result ( $ree );
@      mysql_free_result ( $reee );

echo '</SELECT></td></tr>';


