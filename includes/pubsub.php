<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: pubsub.php
-----------------------------------------------------
 Назначение: Шаблон публикации
=====================================================
*/

if (!isset($results_amount_2) ) $results_amount_2 = 1;

if ($view_template=="YES") $template_sub_pub = implode ('', file('./template/' . $def_template . '/viewinfo.tpl')); else $template_sub_pub = implode ('', file('./template/' . $def_template . '/publication.tpl'));

for ( $iii=0; $iii<$results_amount_2; $iii++ )

{

	$f = $db->fetcharray   ( $re );
	$vi = intval($f['num']);

        $kType=intval($f['type']);

        if ($kType==1) { $name_type="news"; }
        if ($kType==2) { $name_type="tender"; }
        if ($kType==3) { $name_type="board"; }
        if ($kType==4) { $name_type="job"; }
        if ($kType==5) { $name_type="pressrel"; }

	if ( (empty($getcat)) and (empty($getcategory)) )

	{

		$maincatx = explode (":", $f[category]);
		$maincat = explode ("#", $maincatx[0]);

		$getcat = $maincat[0];
		$getcategory = $maincat[0];
		$getsubcat = $maincat[1];
		$getsubsubcat = $maincat[2];

	}


	if ( $iii%2 == 0 )

	{

		$color = "$def_form_back_color";

	}

	else

	{

		$color = "$def_background";

	}

	$template = new Template;

	$template->load($template_sub_pub);


	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

	
	if ( ($getcat != "0") and (isset($getcat)) )

	{

		$r_cat = mysql_query ( "SELECT * FROM $db_category WHERE selector='$getcat' or selector='$getcategory'" );
		$f_cat = mysql_fetch_array ( $r_cat );
		$category = $f_cat[selector];
		$maincategory = $f_cat[category];
		$db->freeresult($r_cat);

	}

	if ( ($getsubcat != "0") and (isset($getsubcat)) )

	{

		$r_cat = mysql_query ( "SELECT * FROM $db_subcategory WHERE ( (catsel='$getcat' or catsel='$getcategory') and (catsubsel = '$getsubcat') )" );
		$f_cat = mysql_fetch_array ( $r_cat );
		$subcategory = $f_cat[catsubsel];
		$mainsubcategory = $f_cat[subcategory];
		$db->freeresult($r_cat);

	}


	if ( ( ($getsubcat != "0") and (isset($getsubcat)) ) and ( ($getsubsubcat != "0") and (isset($getsubsubcat)) ) )

	{

		$r_cat = mysql_query ( "SELECT * FROM $db_subsubcategory WHERE ( (catsel='$getcat' or catsel='$getcategory') and (catsubsel = '$getsubcat') and (catsubsubsel = '$getsubsubcat') )" );
		$f_cat = mysql_fetch_array ( $r_cat );
		$subsubcategory = $f_cat[catsubsubsel];
		$mainsubsubcategory = $f_cat[subsubcategory];
		$db->freeresult($r_cat);

	}


	if (($category == "") and ($subcategory == "") and ($subsubcategory == ""))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation . "/" . $name_type . "-" . $vi ."-0-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/viewinfo.php?vi=" . $vi . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation . "/" . $name_type . "-" . $vi . "-" . $category . "-0-0.html");
		else
		$template->replace("link", $def_mainlocation ."/viewinfo.php?vi=" . $vi . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}


	if (($subcategory != 0) and ($subsubcategory == 0))
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation . "/" . $name_type . "-" . $vi . "-" . $category . "-" . $subcategory . "-0.html" );
		else
		$template->replace("link", $def_mainlocation ."/viewinfo.php?vi=" . $vi . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if ($subsubcategory != 0)
	{
		if ($def_rewrite == "YES")
		$template->replace("link", $def_mainlocation . "/" . $name_type . "-" . $vi . "-" . $category . "-" . $subcategory . "-" . $subsubcategory . ".html");
		else
		$template->replace("link", $def_mainlocation ."/viewinfo.php?vi=" . $vi . "&amp;cat=" . $category . "&amp;subcat=" . $subcategory . "&amp;subsubcat=" . $subsubcategory);
	}

	if ($modul_info=="YES") $target_b="target=\"_blank\""; else $target_b="";
	if ($modul_info=="YES") $company="$f[firmname]"; else $company="";

	$template->replace("target","$target_b");

	$template->replace("date", undate($f[date], "DD.MM.YYYY"));
	$date_time=substr($f[datetime],0,5);
	$template->replace("datetime", "$date_time");
	$template->replace("company", "$company");
	$template->replace("title", "$f[item]");
	$template->replace("shortstory", "$f[shortstory]");

        $fullstory=stripslashes($f[fullstory]);

        if (strlen($fullstory)>5) $template->replace("fullstory", "$fullstory"); else $template->replace("fullstory", "$f[shortstory]");

	if ($f[video]!="") { 

		$video_on="<img src=\"$def_mainlocation/template/$def_template/images/video_on.gif\" alt=\"$def_video_on\" align=\"absmiddle\" border=\"0\">"; 

		$url = urldecode( $f[video] );
		$url = str_replace("&amp;","&", $url );
		
		$source = parse_url ( $url );

		$source['host'] = str_replace( "www.", "", $source['host'] );

		$error_video="";

		if ($source['host'] != "youtube.com" AND $source['host'] != "rutube.ru") $error_video="<font color=red>$def_info_video_not</font>";

		$a = explode('&', $source['query']);
		$j = 0;

		while ($j < count($a)) {
		    $b = explode('=', $a[$j]);
		    if ($b[0] == "v") $video_link = $b[1];
		    $j++;
		}

		if ($error_video=="") {

		if ($source['host'] == "youtube.com")

			$video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$video_link&hl=ru&fs=1\"></param><param name=\"wmode\" value=\"transparent\" /><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$video_link&hl=ru&fs=1\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" wmode=\"transparent\" width=\"425\" height=\"344\"></embed></object>";
		else
			$video = "<OBJECT width=\"425\" height=\"344\"><PARAM name=\"movie\" value=\"http://video.rutube.ru/$video_link\"></PARAM><param name=\"wmode\" value=\"transparent\" /></PARAM><PARAM name=\"allowFullScreen\" value=\"true\"></PARAM><EMBED src=\"http://video.rutube.ru/$video_link\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"344\" allowFullScreen=\"true\" ></EMBED></OBJECT>";

		} else { $video = $error_video; $video_on=""; }

	} else { $video_on=""; $video=""; }

	$view_img='';

	if ($f[img_on]==1) {

            $img_files = array();
            $img_files_small = glob('./info/'.$vi.'-small.*');
            $img_files_full = glob('./info/'.$vi.'.*');

	}

	if (($f[img_on]==1) and ($img_files_small[0]!='')) $img_on="<img src=\"$def_mainlocation/template/$def_template/images/img_on.gif\" alt=\"$def_img_on\" align=\"absmiddle\" border=\"0\">"; else $img_on="";
	if (($f[img_on]==1) and ($img_files_small[0]!='')) { $img_small="<img src=\"$def_mainlocation/info/".basename($img_files_small[0])."\" alt=\"$f[item]\" align=\"left\" border=\"0\">"; $img="<img src=\"$def_mainlocation/info/".basename($img_files_full[0])."\" alt=\"$f[item]\" align=\"left\" border=\"0\">"; } else { $img_small=""; $img=""; }
	if (($f[img_on]==1) and ($img_files_small[0]!='')) $img_link="$def_mainlocation/info/".basename($img_files_full[0]); else $img_link="";

	$template->replace("video_on", "$video_on");
	$template->replace("img_on", "$img_on");
	$template->replace("img_small", "$img_small");
	$template->replace("img", "$img");
	$template->replace("img_link", "$img_link");
	$template->replace("video", "$video");

	if ( ($row_on[1]==1) and ($f[f_name1]!="") ) $f_name1="$row_name[1]: $f[f_name1]<br>"; else $f_name1="";
	if ( ($row_on[2]==1) and ($f[f_name2]!="") ) $f_name2="$row_name[2]: $f[f_name2]<br>"; else $f_name2="";
	if ( ($row_on[3]==1) and ($f[f_name3]!="") ) $f_name3="$row_name[3]: $f[f_name3]<br>"; else $f_name3="";
	if ( ($row_on[4]==1) and ($f[f_name4]!="") ) $f_name4="$row_name[4]: $f[f_name4]<br>"; else $f_name4="";
	if ( ($row_on[5]==1) and ($f[f_name5]!="") ) $f_name5="$row_name[5]: $f[f_name5]<br>"; else $f_name5="";
	if ( ($row_on[6]==1) and ($f[f_name6]!="") ) $f_name6="$row_name[6]: $f[f_name6]<br>"; else $f_name6="";
	if ( ($row_on[7]==1) and ($f[f_name7]!="") ) $f_name7="$row_name[7]: $f[f_name7]<br>"; else $f_name7="";
	if ( ($row_on[8]==1) and ($f[f_name8]!="") ) $f_name8="$row_name[8]: $f[f_name8]<br>"; else $f_name8="";
	if ( ($row_on[9]==1) and ($f[f_name9]!="") ) $f_name9="$row_name[9]: $f[f_name9]<br>"; else $f_name9="";
	if ( ($row_on[10]==1) and ($f[f_name10]!="") ) $f_name10="$row_name[10]: $f[f_name10]<br>"; else $f_name10="";

	$template->replace("f_name1", "$f_name1");
	$template->replace("f_name2", "$f_name2");
	$template->replace("f_name3", "$f_name3");
	$template->replace("f_name4", "$f_name4");
	$template->replace("f_name5", "$f_name5");
	$template->replace("f_name6", "$f_name6");
	$template->replace("f_name7", "$f_name7");
	$template->replace("f_name8", "$f_name8");
	$template->replace("f_name9", "$f_name9");
	$template->replace("f_name10", "$f_name10");

	$template->replace("color", "$color");

	if ($view_template=="YES") {

		$show_info = $f["show_info"];
		$show_info++;
	
		$db->query  ( "UPDATE $db_info SET show_info = '$show_info' WHERE num = '$f[num]'" );

	$template->replace("hits", "$show_info");
	
	}

		$date_day = date ( "d" );
 		$date_month = date ( "m" );
	 	$date_year = date ( "Y" );

 		list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f["date"] );

		$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
		$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

 		if ( $second_date > $first_date )

 		{
 			$days = $second_date-$first_date;
 		}

 		else
		
 		{
 			$days = $first_date-$second_date;
 		}

		$days_result = round( $f[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );

	
	$template->replace("resilt", "$days_result");

	$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template->publish();
	
	unset ($view_img, $view_img_file, $view_img_type, $img_block[$xxl], $handle_img);

	unset ($getcat, $getcategory, $getsubcat, $getsubsubcat);

}

?>