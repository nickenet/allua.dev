<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Mady
=====================================================
 Файл: qsearch.php
-----------------------------------------------------
 Назначение: Автопоиск
=====================================================
*/

include ( "../conf/config.php" );
include ( "../includes/functions.php" );
include ( "../includes/$def_dbtype.php" );
include ( "../connect.php" );
include ( "../includes/sqlfunctions.php" );

$q = htmlspecialchars(strip_tags(strtolower(stripslashes(trim(iconv('utf-8','windows-1251',$_GET['q']))))), ENT_QUOTES);
if (!$q) return;

$q_search_f = $db->query  ( "SELECT * FROM $db_zsearch WHERE item LIKE '$q%'" );
@$results_amount_qsearch = mysql_num_rows ($q_search_f);

@header("Content-type: text/html; charset=windows-1251");

if ($results_amount_qsearch>0) {
    
    for ($iqs=0; $iqs<$results_amount_qsearch; $iqs++ )

	{
            $f_qsearch_f = $db->fetcharray  ( $q_search_f );
            echo "$f_qsearch_f[item]\n";
        }
    
}

?>