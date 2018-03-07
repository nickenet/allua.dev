<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: tag_news.php
-----------------------------------------------------
 Назначение: Вывод облака тегов для новостей
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$could_tag=substr ( trim($could_tag), 0, - 1 );
$could_tag=explode(", ", $could_tag);
$c_tag=array_count_values($could_tag);

        $counts = array();
	$tags = array();
	$list = array();
	$sizes = array( "clouds_xsmall", "clouds_small", "clouds_medium", "clouds_large", "clouds_xlarge" );
	$min   = 1;
	$max   = 1;
	$range = 1;

        $min   = min($c_tag);
	$max   = max($c_tag);
	$range = ($max-$min);
        if (!$range) $range = 1;

        foreach ($c_tag as $tag => $value) {

		$list[$tag]['tag']   = $tag;
		$list[$tag]['size']  = $sizes[sprintf("%d", ($value-$min)/$range*4 )];
		$list[$tag]['count']  = $value;
	}

        usort ($list, "compare_tags");

        foreach ($list as $value) {
		if (trim($value['tag']) != "" ) $tags[] = "<a href=\"".$def_mainlocation."/get.php?skey=".urlencode($value['tag'])."\" class=\"{$value['size']}\" title=\"".$def_news_metka_sum." ".$value['count']."\">".$value['tag']."</a>";
	}

        $template_tag_news = implode ('', file('./template/' . $def_template . '/tag_news.tpl'));

        $template_tag_n = new Template;

        $template_tag_n->load($template_tag_news);

        $template_tag_n->replace("tags", implode(", ", $tags));

        $template_tag_n->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_tag_n->publish();

?>