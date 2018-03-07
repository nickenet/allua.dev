<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: info_firm.php
-----------------------------------------------------
 Назначение: Информационный блок компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
		// Информационный блок

		if (( $f['info'] > 0 ) and ($def_allow_info == "YES") and (ifEnabled($f['flag'], "infoblock")))
		{
			if ( $f['news'] > 0 )
			{
				if ($def_rewrite == "YES")
				$link5 = "<a href=\"$def_mainlocation/news-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link5 = "<a href=\"publication.php?id=$f[selector]&amp;type=1&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[6]!='') $news_link_s=$link5.$form_set[6].'</a>'; else $news_link_s=$link5.$def_info_news.'</a>';
				$link5.= "$def_info_news</a>&nbsp;&nbsp;[$f[news]]";

				$news_link = $def_info_news;
			}
			else
			{
                                $news_link_s="";
 				$link5 = "$def_info_news&nbsp;&nbsp;[0]";
				$news_link = "";
			}

			if ( $f['tender'] > 0 )
			{
				if ($def_rewrite == "YES")
				$link6 = "<a href=\"$def_mainlocation/tender-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link6 = "<a href=\"publication.php?id=$f[selector]&amp;type=2&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[7]!='') $tender_link_s=$link6.$form_set[7].'</a>'; else $tender_link_s=$link6.$def_info_tender.'</a>';
				$link6.= "$def_info_tender</a>&nbsp;&nbsp;[$f[tender]]";

				$tender_link = $def_info_tender;
			}
			else
			{
                                $tender_link_s="";
 				$link6 = "$def_info_tender&nbsp;&nbsp;[0]";
				$tender_link = "";
			}

			if ( $f['board'] > 0 )

			{
				if ($def_rewrite == "YES")
				$link7 = "<a href=\"$def_mainlocation/board-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link7 = "<a href=\"publication.php?id=$f[selector]&amp;type=3&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[8]!='') $board_link_s=$link7.$form_set[8].'</a>'; else $board_link_s=$link7.$def_info_board.'</a>';
				$link7.= "$def_info_board</a>&nbsp;&nbsp;[$f[board]]";

				$board_link = $def_info_board;
			}
			else
			{
                                $board_link_s="";
 				$link7 = "$def_info_board&nbsp;&nbsp;[0]";
				$board_link = "";
			}

			if ( $f['job'] > 0 )
			{
				if ($def_rewrite == "YES")
				$link8 = "<a href=\"$def_mainlocation/job-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link8 = "<a href=\"publication.php?id=$f[selector]&amp;type=4&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[9]!='') $job_link_s=$link8.$form_set[9].'</a>'; else $job_link_s=$link8.$def_info_job.'</a>';
				$link8.= "$def_info_job</a>&nbsp;&nbsp;[$f[job]]";

				$job_link = $def_info_job;
			}
			else
			{
                                $job_link_s="";
 				$link8 = "$def_info_job&nbsp;&nbsp;[0]";
				$job_link = "";
			}

			if ( $f['pressrel'] > 0 )
			{
				if ($def_rewrite == "YES")
				$link9 = "<a href=\"$def_mainlocation/pressrel-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link9 = "<a href=\"publication.php?id=$f[selector]&amp;type=5&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[10]!='') $pressrel_link_s=$link9.$form_set[10].'</a>'; else $pressrel_link_s=$link9.$def_info_pressrel.'</a>';
				$link9.= "$def_info_pressrel</a>&nbsp;&nbsp;[$f[pressrel]]";

				$pressrel_link = $def_info_pressrel;
			}
			else
			{
                                $pressrel_link_s="";
 				$link9 = "$def_info_pressrel&nbsp;&nbsp;[0]";
				$pressrel_link = "";
			}
		}
			else
			{
                                $news_link_s="";
 				$link5 = "$def_info_news&nbsp;&nbsp;[0]";
				$news_link = "";

                                $tender_link_s="";
 				$link6 = "$def_info_tender&nbsp;&nbsp;[0]";
				$tender_link = "";

                                $board_link_s="";
 				$link7 = "$def_info_board&nbsp;&nbsp;[0]";
				$board_link = "";

                                $job_link_s="";
 				$link8 = "$def_info_job&nbsp;&nbsp;[0]";
				$job_link = "";

                                $pressrel_link_s="";
 				$link9 = "$def_info_pressrel&nbsp;&nbsp;[0]";
				$pressrel_link = "";

			}

		$template->replace("newslist", $link5);

		$template->replace("news", $news_link);

		$template->replace("tenderlist", $link6);

		$template->replace("tender", $tender_link);

		$template->replace("boardlist", $link7);

		$template->replace("board", $board_link);

		$template->replace("joblist", $link8);

		$template->replace("job", $job_link);

		$template->replace("pressrellist", $link9);

		$template->replace("pressrel", $pressrel_link);

?>
