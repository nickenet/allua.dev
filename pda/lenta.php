<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: lenta.php
-----------------------------------------------------
 Назначение: Вывод ленты публикаций компаний
=====================================================
*/

header("Content-type: text/html; charset=windows-1251");
include ("../conf/config.php");
include ("../includes/functions.php");
include ("../includes/$def_dbtype.php");
include ("../connect.php");
include ("../includes/sqlfunctions.php");
$lang = $def_language;
include ("../lang/language.$lang.php");
include ("conf/config.php");

 $def_mainlocation_pda = $def_mainlocation.'/'.$def_pda;

$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die();

$run = mysql_query("SELECT * FROM $db_info ORDER BY date DESC, datetime DESC LIMIT ".$postnumbers." OFFSET ".$offset);

while($row = mysql_fetch_array($run)) {
    
       $template_sub = implode ('', file('./template/' . $def_template . '/publication.tpl'));

       $template = new Template;

       $template->load($template_sub);

       $template->replace("date", undate($row['date'], "DD.MM.YYYY"));

       $template->replace("company", $row['firmname']);
       $template->replace("title", $row['item']);
       $template->replace("shortstory", $row['shortstory']);
       $template->replace("link_to_company", $def_mainlocation_pda.'/view.php?id='.$row['firmselector']);
       $template->replace("link", $def_mainlocation_pda.'/info.php?vi='.$row['num']);
       
       $filter='';

       if ($row['type']==1) { $filter="news"; }
       if ($row['type']==2) { $filter="tender"; }
       if ($row['type']==3) { $filter="board"; }
       if ($row['type']==4) { $filter="job"; }
       if ($row['type']==5) { $filter="pressrel"; }

        if ($filter!='') $template->replace("filter", $filter); else $template->replace("filter", "");

       $template->publish();
}

?>