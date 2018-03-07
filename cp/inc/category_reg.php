<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_reg.php
-----------------------------------------------------
 Назначение: Вывод списка категорий при регистрации
=====================================================
*/

if (empty($title_cp)) die();

?>

  <?php echo $def_admin_category; ?>:
    <font color="red">*</font>
     <SELECT NAME="category[]" multiple style="width:550px; height:210px;">

<?php

$r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++ )

{

	$f = $db->fetcharray  ( $r );

	$ra = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsel=$f[selector] ORDER BY subcategory" );
	$results_amount2 = mysql_num_rows ( $ra );

	if ( ($results_amount2 == 0) ) $results_amount2 = 1;

	for ( $j=0; $j < $results_amount2; $j++)

	{

		$fa = $db->fetcharray  ( $ra );
		$raa = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel=$f[selector] and catsubsel=$fa[catsubsel] ORDER BY subsubcategory" );
		@      $results_amount3 = mysql_num_rows ( $raa );

		if (($results_amount3 == 0) and ($results_amount2 == 0)) $results_amount3 = 1;
		if (($results_amount3 == 0) and ($results_amount2 != 0)) $results_amount3 = 1;

		for ( $k=0; $k < $results_amount3; $k++ )

		{

			@      $faa = $db->fetcharray  ( $raa );

			if ( ( !isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo "<OPTION VALUE=\"$f[selector]#0#0\">$f[category]";

			if ( ( isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

			echo "<OPTION VALUE=\"$f[selector]#$fa[catsubsel]#0\">$f[category] :: $fa[subcategory]";

			if ( ( isset($fa[catsubsel]) ) and ( isset($faa[catsubsubsel]) ) )

			echo "<OPTION VALUE=\"$f[selector]#$fa[catsubsel]#$faa[catsubsubsel]\">$f[category] :: $fa[subcategory] :: $faa[subsubcategory]";

		}

	}

}

@  mysql_free_result ( $r );
@  mysql_free_result ( $ra );
@  mysql_free_result ( $raa );

echo "</SELECT><br>* $def_sel_ctrl.</td></tr>";

?>