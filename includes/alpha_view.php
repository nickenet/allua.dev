<?php
/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: alpha_view.php
-----------------------------------------------------
 Назначение: Вывод букв для быстрого поиска по букве
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
        $template_alpha = new Template;

        $template_alpha->set_file('alpha.tpl');

        $template_alpha->replace("bgcolor", $def_kurs_background);
        
        $letters = explode("#", $def_index_search);
 
        for ($a=0;$a<count($letters);$a++) { 

            $view_alpha .= "<a class=\"alpha\" href=\"$def_mainlocation/alpha.php?letter=$letters[$a]\">$letters[$a]</a>&nbsp;&nbsp;";
        }

        $template_alpha->replace("alpha", $view_alpha);
        
        $template_alpha->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_alpha->publish();
?>


