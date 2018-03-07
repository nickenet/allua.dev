<?php
/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: category_reg.php
-----------------------------------------------------
 Назначение: Выводит список категорий в форме регистрации
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$template->replace("category", $def_category);

$category_list = explode(":", $category);

$re = $db->query  ( "select selector, category,	sccounter, ssccounter, fcounter from $db_category order by category" ) or die (mysql_error());
$results_amount1=mysql_num_rows($re);

for($i=0;$i<$results_amount1;$i++)

{
	$fe= $db->fetcharray ($re);
	$ree = $db->query  ( "select * from $db_subcategory where catsel=$fe[selector] order by subcategory");
	$results_amount2=mysql_num_rows($ree);

	if ($fe[sccounter]==0) $cat_view .= '<option value="'.$fe[selector].'#0#0" class="mainXR">'.$fe[category].'</option>';

        else { $cat_view .= '<optgroup label="'.$fe[category].'" class="catXR">';

	for($j=0;$j<$results_amount2;$j++)

	{
		$fee= $db->fetcharray ($ree);

		$reee = $db->query  ( "select * from $db_subsubcategory where catsel=$fe[selector] and catsubsel = $fee[catsubsel] order by subsubcategory");
		@$results_amount3=mysql_num_rows($reee);

                if ($fee[ssccounter]==0) $cat_view .= "<option value=\"$fe[selector]#$fee[catsubsel]#0\">&nbsp;+--&nbsp;$fee[subcategory]</option>";

                    else { $cat_view .= "<optgroup label=\"+--$fee[subcategory]\" class=\"subXR\">";

                        for($k=0;$k<$results_amount3;$k++)

                        {
                                @$feee= $db->fetcharray ($reee);

                                $found= 0;

                                    for ( $cat1=0;$cat1<count($category_list);$cat1++) {
                			if (!isset($fee[catsubsel])) $fee[catsubsel]=0;
                        		if (!isset($feee[catsubsubsel])) $feee[catsubsubsel]=0;
                                        if ($category_list[$cat1] == "$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]") $found = 1; }
                                if ($found == 0) $cat_view .= "<option value=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\">&nbsp;&nbsp;&nbsp;&nbsp;+--&nbsp;$feee[subsubcategory]</option>";
                                else $cat_view .= "<option value=\"$fe[selector]#$fee[catsubsel]#$feee[catsubsubsel]\" selected>&nbsp;&nbsp;&nbsp;&nbsp;+--&nbsp;$feee[subsubcategory]</option>";
                        }
                        $cat_view .= "</optgroup>";
                }
	}
        $cat_view .= "</optgroup>";
        }
}

@ $db->freeresult($re);
@ $db->freeresult($ree);
@ $db->freeresult($reee);

$template->replace("cat_view", $cat_view);
$template->replace("sel_ctrl", $def_sel_ctrl);

?>
