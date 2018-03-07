<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: review_firm.php
-----------------------------------------------------
 Назначение: Подключение комментариев
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

		if (($def_reviews_enable == "YES")  and ($f['off_rev'] != '1') ) {

			$rev_good=''; $rev_bad='';

			$rx = mysql_query ( "SELECT * FROM $db_reviews WHERE company='$f[selector]' and status='on' ORDER BY id DESC" );
			@$reviews=mysql_num_rows($rx);

			if ($reviews > 0)
			{
                            if ($def_rewrite == "YES")
                            $viewreviews.= '<a href="'.$def_mainlocation.'/view-reviews-'.$f['selector'].'-'.$cat.'-'.$subcat.'-'.$subsubcat.'-'.$kPage.'.html">'.$def_view_reviews.'</a> ['.$reviews.']';
                            else
                            $viewreviews.= '<a href="'.$def_mainlocation.'/reviews.php?id='.$f['selector'].'&amp;cat='.$cat.'&amp;subcat='.$subcat.'&amp;subsubcat='.$subsubcat.'">'.$def_view_reviews.'</a> ['.$reviews.']';

			if ($f['rev_good']>0) $rev_good = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/rev_good.png" align="absmiddle"> '.$f['rev_good'];
                        if ($f['rev_bad']>0) $rev_bad = '<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/rev_bad.png" align="absmiddle"> '.$f['rev_bad'];
			}
			else $viewreviews = $def_view_reviews.' [0]';

                        if ($form_set[12]!='') $def_add_a_review=$form_set[12];

			if ($def_rewrite == "YES") $addreview = '<a href="'.$def_mainlocation.'/review-'.$f[selector].'-'.$cat.'-'.$subcat.'-'.$subsubcat.'-'.$kPage.'.html">'.$def_add_a_review.'</a>';
			else $addreview = '<a href="'.$def_mainlocation.'/review.php?id='.$f[selector].'&amp;cat='.$cat.'&amp;subcat='.$subcat.'&amp;subsubcat='.$subsubcat.'">'.$def_add_a_review.'</a>';
		}

		if ($f[off_rev] == '1') 
		{ 
        		$addreview = $def_closed_company;
                	$viewreviews = $def_closed_company;
		}

		$template->replace("addreview", $addreview);

		$template->replace("viewreviews", $viewreviews);
                $template->replace("rev_good", $rev_good);
                $template->replace("rev_bad", $rev_bad);
?>
