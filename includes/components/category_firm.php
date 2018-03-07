<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_main.php
-----------------------------------------------------
 Назначение: Подключение определения категорий фирм
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

// Категории
$dev_out= '<div align="left">&nbsp;'.$def_also_registered_in.'<br />';

$catzzz=explode(":", $f['category']);

for ($zzz=0;$zzz<count($catzzz);$zzz++)

{

$catzzz1 = explode ("#", $catzzz[$zzz]);

     $res2 = $db->query ( "SELECT * FROM $db_category WHERE selector='$catzzz1[0]'");
     $fe2 = $db->fetcharray ( $res2 );

        if ($db->numrows($res2) > 0)
            {
                $caturl = "category=$catzzz1[0]";
                $showcategory2 = $fe2['category'];
            }
         else $showcategory2 = "";
    $db->freeresult ( $res2 );

if ($catzzz[1]!=0) {

     $res = $db->query ( "SELECT * FROM $db_subcategory WHERE catsubsel='$catzzz1[1]'");
     $fe = $db->fetcharray ( $res );

        if ($db->numrows($res) > 0)
            {
                $caturl = "cat=$catzzz1[0]&subcat=$catzzz1[1]";
                $showcategory = " / $fe[subcategory]";
            }
        else $showcategory = "";

     $db->freeresult ( $res );

} else $showcategory="";

if ($catzzz[2]!=0) {

     $res3 = $db->query ( "SELECT * FROM $db_subsubcategory WHERE catsel='$catzzz1[0]' and catsubsel='$catzzz1[1]' and catsubsubsel='$catzzz1[2]'");
     $fe3 = $db->fetcharray ( $res3 );

        if ($db->numrows($res3) > 0)
            {
                $caturl .= "&subsubcat=$catzzz1[2]";
                $showsubcategory = " / $fe3[subsubcategory]";
            }
        else
                $showsubcategory = "";
                $db->freeresult ( $res3 );
} else  $showsubcategory = "";

$dev_out.=  '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/arrow.gif"> <a href='.$def_mainlocation.'/index.php?'.$caturl.'>'.$showcategory2.' '.$showcategory.' '.$showsubcategory.'</a><br />';

}

$dev_out.= '</div>';

                $template->replace("cats", $dev_out);

?>
