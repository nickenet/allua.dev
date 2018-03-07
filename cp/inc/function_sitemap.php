<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: function_sitemap.php
-----------------------------------------------------
 Назначение: Функции sitemap
=====================================================
*/

	function index_sitemap() {

            global $def_mainlocation;

		$map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		$img_header = glob('../sitemaps/*.xml');

                foreach ($img_header as $value) {

                    $url_to = basename($value);

		    if ($url_to!='sitemap.xml') {

	                    $lastmod = date('Y-m-d', filemtime('../sitemaps/'.$url_to));
	
        	            $map .= "<sitemap>\n<loc>$def_mainlocation/sitemaps/$url_to</loc>\n<lastmod>$lastmod</lastmod>\n</sitemap>\n";

		    }

                }

                $map .= "</sitemapindex>";

                $map = iconv("CP1251", "UTF-8//IGNORE", $map);

                $index_fs = fopen("../sitemaps/sitemap.xml", "wb+");
                fwrite($index_fs, $map);
                fclose($index_fs);

		@chmod("../sitemaps/sitemap.xml", 0666);

	}

	function url_sitempap( $data_url ) {

		$map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$map .= $data_url;
		$map .= "</urlset>";

		return $map;

	}        

	function xml_get($loc, $lastmod, $priority ) {

		$loc = htmlspecialchars( $loc );

		$xml = "\t<url>\n";
		$xml .= "\t\t<loc>$loc</loc>\n";
		$xml .= "\t\t<lastmod>$lastmod</lastmod>\n";
		$xml .= "\t\t<priority>$priority</priority>\n";
		$xml .= "\t</url>\n";

                $_SESSION['link_map']=$_SESSION['link_map']+1;

		return $xml;
	}

        function dubl_cat($razdel,$cat,$type) {

            global $def_mainlocation;

            if ($type==0) $url_dubl_cat=$def_mainlocation.'/'.$razdel.'.php?category='.$cat;
            else $url_dubl_cat=$def_mainlocation.'/'.$razdel.'.php?category='.$cat.'&type='.$type;


            return $url_dubl_cat;

        }

        function fopen_map ($map_all, $file_name ) {

            $map_all = iconv("CP1251", "UTF-8//IGNORE", $map_all);

            $index_fs = fopen("../sitemaps/$file_name", "wb+");
            fwrite($index_fs, $map_all);
            fclose($index_fs);

            @chmod("../sitemaps/$file_name", 0666);

        }

?>
