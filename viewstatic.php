<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: viewstatic.php
-----------------------------------------------------
 Назначение: Вывод статической страницы
=====================================================
*/

include ("./defaults.php");

header('Cache-control: private');

$vs=mysql_real_escape_string(strip_tags(safeHTML(trim($_GET[vs]))));

$full_news = $db->query ( "SELECT * FROM $db_static WHERE name='$vs' LIMIT 1" );
@$results_amount_n = mysql_num_rows ( $full_news );

if ($results_amount_n==1) {

    $f_n= $db->fetcharray($full_news);

	$incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';

        $incomingline.= ' | '.$f_n['title'];

	$help_section = (string)$viewstatic_help;

	$show_banner="NO";

	if ($f_n['metatitle']!='') $incomingline_firm =  htmlspecialchars($f_n['metatitle'],ENT_QUOTES,$def_charset); else $incomingline_firm =  htmlspecialchars($f_n['title'],ENT_QUOTES,$def_charset);

        if ($f_n['metadescr']!='') $descriptions_meta = htmlspecialchars($f_n['metadescr'],ENT_QUOTES,$def_charset); else {
            
            $descriptions_meta = chek_meta($f_n['full']);
            $descriptions_meta = substr($descriptions_meta, 0, 200);
            $descriptions_meta = substr($descriptions_meta, 0, strrpos($descriptions_meta, ' '));
            $descriptions_meta = trim($descriptions_meta);
            
        }

        if ($f_n['metakeywords']!='') $keywords_meta = htmlspecialchars($f_n['metakeywords'],ENT_QUOTES,$def_charset);
        else $keywords_meta=check_keywords($f_n['full']);

        if ($f_n['noindex']==1) $meta_index='<meta name="robots" content="noindex,nofollow" />'."\n";

if (!isset($_GET['print'])) include ( "./template/$def_template/header.php" );

// Обрабатываем переменые

		if ($f_n['full_tpl']!='')  $template_full=trim(htmlspecialchars($f_n['full_tpl'],ENT_QUOTES,$def_charset)).'.tpl';
                else $template_full='static.tpl';

                if (isset($_GET['print'])) $template_full='static_print.tpl';

                if (file_exists('./template/' . $def_template . '/'.$template_full)) $template_full_news = implode ('', file('./template/' . $def_template . '/'.$template_full));
                else die("Не найден шаблон $template_full");

                $date_add=data_to_news($f_n['date']);
                $title=$f_n['title'];
                $selector=intval($f_n['selector']);
                $full=stripcslashes($f_n['full']);
                $hits=intval($f_n['hit']);
                $comment_news='';

                // Количество просмотров

		@	$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		if ($ip == "") {$ip=$_SERVER["REMOTE_ADDR"];}

		if ($ip != $f_n['ip']) {
                    $hits++;
                    $db->query ( "UPDATE $db_static SET hit = '$hits', ip = '$ip' WHERE selector='$selector'" );
                }

                $template = new Template;

                $template->load($template_full_news);

		$template->replace("date", $date_add);
                $template->replace("title", $title);
                $template->replace("text", $full);
                $template->replace("hits", $hits);

                $template->replace("color", $color);

                $link_print = $def_mainlocation.'/viewstatic.php?vs='.$vs.'&print';

                $template->replace("link_print", $link_print);

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                if (isset($_GET['print'])) {
                     
                    $link = $def_mainlocation.'/viewstatic.php?vs='.$f_n['name'].'&print';

                    // QR код с URL страницы

                    $qr_code='<img src="http://chart.apis.google.com/chart?cht=qr&chs=120x120&chl='.$link.'" />';

                    $template->replace("link", $link);
                    $template->replace("qr", $qr_code);

                }

                $template->publish();

if (!isset($_GET['print'])) include ( "./template/$def_template/footer.php" );

}

else

{
        $incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';

        if ($def_rewrite_news == "YES") $incomingline.= ' | <a href="'.$def_mainlocation.'/'.$f_n['name'].'.html">'.$def_title_error.'</a>';
	else $incomingline.= ' | <a href="'.$def_mainlocation.'/viewstatic.php?vs='.$f_n['name'].'">'.$def_title_error.'</a>';

        $incomingline_firm = $def_title_error;

	@header( "HTTP/1.0 404 Not Found" );
	include ( "./template/$def_template/header.php" );
            include ( "./includes/error_page.php" );
	include ( "./template/$def_template/footer.php" );
}

?>