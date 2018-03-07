<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: filial_firm.php
-----------------------------------------------------
 Назначение: Подключение филиалов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
		// Филиалы

                if ($form_set[18]!='') $def_filial=$form_set[18];

		if (( $f['filial'] > 0 ) and (ifEnabled($f['flag'], "filial")))
			{
				if ($def_rewrite == "YES")
				$link10 = "<a href=\"$def_mainlocation/filial-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link10 = "<a href=\"filial.php?id=$f[selector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
				$link10.= "$def_filial</a>&nbsp;&nbsp;[$f[filial]]";

				$filial_link = $def_filial;
			}
		else
			{
 				$link10 = "";
				$filial_link = "";
			}
		$template->replace("filiallist", $link10);
		$template->replace("filial", $filial_link);
?>
