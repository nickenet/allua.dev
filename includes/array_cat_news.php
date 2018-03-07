<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: array_cat_news.php
-----------------------------------------------------
 Назначение: Массив категорий новостей. Работа с кэшем
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

// Массив категорий

if ((filesize('system/news.dat') > 0) and ($def_news_cache_cat=="YES")) {

    $tmp = file_get_contents('system/news.dat');
    $tmp = unserialize($tmp);
    $array_cat = unserialize($tmp['array_cat']);
    $array_name = unserialize($tmp['array_name']);
    $array_url = unserialize($tmp['array_url']);

         for ( $jj=0; $jj<count($array_cat); $jj++ ) {
            $array_cat[$array_cat['selector']] = $array_cat['category'];
            $array_name[$array_name['name']] = $array_name['name'];
            $array_url[$array_url['selector']] = $array_url['name'];
        }
}
    else {

$r_cat=$db->query ("SELECT * FROM $db_categorynews ORDER BY selector") or die ("mySQL error!");
$array_cat=array();
$array_name=array();
$res_rcat = mysql_num_rows ( $r_cat );
        for ( $jj=0; $jj<$res_rcat; $jj++ ) {
            $f_catf=$db->fetcharray ($r_cat);
            $array_cat[$f_catf['selector']] = $f_catf['category'];
            $array_name[$f_catf['name']] = $f_catf['name'];
            $array_url[$f_catf['selector']] = $f_catf['name'];
        }
}

if ((filesize('system/news.dat') == 0) and ($def_news_cache_cat=="YES")) {
    $tmp=array();
    $tmp['array_cat']=serialize($array_cat);
    $tmp['array_name']=serialize($array_name);
    $tmp['array_url']=serialize($array_url);
    $tmp= serialize($tmp);
    file_put_contents('system/news.dat', $tmp);
}

?>