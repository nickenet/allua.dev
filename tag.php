<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: tag.php
-----------------------------------------------------
 Назначение: Вывод меток компаний
=====================================================
*/

include ( "./defaults.php" );

if ( $_GET['skey'] <> '' ) $metka_get = rawurldecode ($_GET['skey']);

$metka_get=htmlspecialchars ( strip_tags ( stripslashes ( trim ( $metka_get ) ) ), ENT_QUOTES, $def_charset) ;

if (strlen($metka_get)>1) {
    
$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_dir;

$r = $db->query ("SELECT * FROM $db_users WHERE  (keywords LIKE '%$metka_get%') and firmstate = 'on' ORDER BY flag, firmname LIMIT $page1, $def_count_dir");
    $rez_in=$db->query ("SELECT COUNT(*) FROM $db_users WHERE  (keywords LIKE '%$metka_get%') and firmstate = 'on'");
    $result_in=mysql_result($rez_in, 0 ,0);

@$results_amount = mysql_num_rows ( $r );

$incomingline =  '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$def_firm_metka_s.' "'.$metka_get.'"</font>';
$incomingline_firm = $metka_get;

        $help_section = (string)$tag_help;

include ( "./template/$def_template/header.php" );

main_table_top($metka_get);

if ( $results_amount > 0 )

{
    $fetchcounter=$results_amount;
    
    include ("./includes/sub.php");

    // Страницы

if ( $result_in > $def_count_dir )

{
	if ((($kPage*$def_count_dir)-($def_count_dir*5)) >= 0) $first=($kPage*$def_count_dir)-($def_count_dir*5);
	else $first=0;

	if ((($kPage*$def_count_dir)+($def_count_dir*6)) <= $result_in) $last =($kPage*$def_count_dir)+($def_count_dir*6);
	else $last = $result_in;

	@$z=$first/$def_count_dir;

	if ($kPage > 0) {

            $prev_page =  '<a href="'.$def_mainlocation.'/tag.php?skey='.$metka_get.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';

        } else $prev_page = '';

        $page_news = '';

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_count_dir )

	{
		if ( $z == $kPage )

		{
			$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
			$z++;
		}

		else

		{
			$page_news .= '<a href="'.$def_mainlocation.'/tag.php?skey='.$metka_get.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
			$z++;
		}
	}

        if ($kPage - (($result_in / $def_count_dir) - 1) < 0) {

            $next_page = '<a href="'.$def_mainlocation.'/tag.php?skey='.$metka_get.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';

        } else $next_page ='';

        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

}

include ( "./includes/tag_firms.php" ); // подключаем облако тегов

} else {
    
        include ( "./includes/error_page.php" );
        
}

main_table_bottom();

} else

{

$incomingline =  $def_title_error;

include ( "./template/$def_template/header.php" );

    include ( "./includes/error_page.php" );

}

include ( "./template/$def_template/footer.php" );

?>