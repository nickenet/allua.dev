<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: sqlfunctions.php
-----------------------------------------------------
 Назначение: Функция по работе с тарифами и категориями
=====================================================
*/

function switchmemberships ($selector, $flag, $section, $job)

{

	global $db_users;
	global $db_images;
	global $db_exelp;
	global $db_video;
	global $db_offers;
	global $db_info;
	global $db_category;
	global $db_subcategory;
	global $db_subsubcategory;

	if ($section == "admin") $folder = "../"; else $folder = "";

	include ($folder . "./conf/memberships.php");


	$logo_enabled = "def_" . $flag . "_logo";
	$sxema_enabled = "def_" . $flag . "_sxema";
	$banner_enabled = "def_" . $flag . "_banner";
	$banner2_enabled = "def_" . $flag . "_banner2";

	$images_enabled = "def_" . $flag . "_images";
	$set_images = "def_" . $flag . "_setimages";

	$products_enabled = "def_" . $flag . "_products";
	$set_products = "def_" . $flag . "_setproducts";

	$exel_enabled = "def_" . $flag . "_exel";
	$set_exel = "def_" . $flag . "_setexel";

	$video_enabled = "def_" . $flag . "_video";
	$set_video = "def_" . $flag . "_setvideo";

	$info_enabled = "def_" . $flag . "_infoblock";
	$set_info = "def_" . $flag . "_setinfo";


	$sql = "SELECT selector, flag, category, prices, images, exel, video, info, news, tender, board, job, pressrel FROM $db_users
          WHERE selector = '$selector' LIMIT 1";

	$r = mysql_query ($sql);

	if ( !$r ) error ( "mySQL error", mysql_error() );

	$f = mysql_fetch_array ( $r );

	if ( $$logo_enabled != "YES" )

	{



		@unlink ( $folder . "./logo/$selector.gif" );
		@unlink ( $folder . "./logo/$selector.bmp" );
		@unlink ( $folder . "./logo/$selector.jpg" );
		@unlink ( $folder . "./logo/$selector.png" );

	}

	if ( $$sxema_enabled != "YES" )

	{



		@unlink ( $folder . "./sxema/$selector.gif" );
		@unlink ( $folder . "./sxema/$selector.bmp" );
		@unlink ( $folder . "./sxema/$selector.jpg" );
		@unlink ( $folder . "./sxema/$selector.png" );

	}


	if ( ( $$banner_enabled != "YES" ) or (( $def_onlypaid == "YES" ) and ( $flag == "D" )) )

	{

		@unlink ( $folder . "./banner/$selector.gif" );
		@unlink ( $folder . "./banner/$selector.bmp" );
		@unlink ( $folder . "./banner/$selector.jpg" );
		@unlink ( $folder . "./banner/$selector.png" );

	}

	if ( ( $$banner2_enabled != "YES" ) or (( $def_onlypaid == "YES" ) and ($flag == "D" ) ) )

	{

		@unlink ( $folder . "./banner2/$selector.gif" );
		@unlink ( $folder . "./banner2/$selector.bmp" );
		@unlink ( $folder . "./banner2/$selector.jpg" );
		@unlink ( $folder . "./banner2/$selector.png" );

	}


	if ( ( $def_onlypaid == "YES" ) and ( $flag == "D" ) and ( $f[flag] != "D" ) and ($job == "cron") )

	{

		$category = explode (":", $f[category]);

		for ($index = 0; $index < count ( $category ); $index++)

		{

			$new_cat = explode ("#", $category[$index]);

			if ($new_cat[0] != $prev_cat)

			mysql_query("UPDATE $db_category SET fcounter = fcounter-1 where selector=$new_cat[0]") or die (mysql_error());

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

			mysql_query("UPDATE $db_subcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]") or die (mysql_error());

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

			mysql_query("UPDATE $db_subsubcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]") or die (mysql_error());

			$prev_cat=$new_cat[0];
			$prev_subcat=$new_cat[1];

		}

	}


	$ra = mysql_query ( "SELECT * FROM $db_images where firmselector = $selector order by num" );
	if (!$ra) error ("mySQL error", mysql_error() );

	$results_amount_images = mysql_num_rows ( $ra );

	if ( (( $def_onlypaid == "YES" ) and ( $flag == "D") ) or ($$images_enabled != "YES") or ( $results_amount_images > $$set_images ) )

	{

		$del_images=$results_amount_images-$$set_images;

		for ( $i2=0; $i2<$del_images; $i2++ )

		{

			$fa = mysql_fetch_array ( $ra );

			@unlink($folder . "./gallery/$fa[num].gif");
			@unlink($folder . "./gallery/$fa[num].bmp");
			@unlink($folder . "./gallery/$fa[num].jpg");
			@unlink($folder . "./gallery/$fa[num].png");

			@unlink($folder . "./gallery/$fa[num]-small.gif");
			@unlink($folder . "./gallery/$fa[num]-small.bmp");
			@unlink($folder . "./gallery/$fa[num]-small.jpg");
			@unlink($folder . "./gallery/$fa[num]-small.png");

			mysql_query("DELETE FROM $db_images where firmselector='$selector' and num='$fa[num]'");

		}

	}

	if ( ( ( $def_onlypaid == "YES" ) and ( $flag == "D" ) ) or ( $$images_enabled != "YES" ) )

	$imageSQL = ", images = 0";

	else

	$imageSQL = ", images = " . $$set_images;


	$ra = mysql_query ( "SELECT * FROM $db_exelp where firmselector = $selector order by num" );
	if (!$ra) error ("mySQL error", mysql_error() );

	$results_amount_exel = mysql_num_rows ( $ra );

	if ( (( $def_onlypaid == "YES" ) and ( $flag == "D") ) or ($$exel_enabled != "YES") or ( $results_amount_exel > $$set_exel ) )

	{

		$del_exel=$results_amount_exel-$$set_exel;

		for ( $i2=0; $i2<$del_exel; $i2++ )

		{

			$fa = mysql_fetch_array ( $ra );

			@unlink($folder . "./exel/$fa[num].xls");
			@unlink($folder . "./exel/$fa[num].xlsx");
			@unlink($folder . "./exel/$fa[num].doc");
			@unlink($folder . "./exel/$fa[num].docx");
			@unlink($folder . "./exel/$fa[num].pdf");
			@unlink($folder . "./exel/$fa[num].zip");
			@unlink($folder . "./exel/$fa[num].rar");

			mysql_query("DELETE FROM $db_exelp where firmselector='$selector' and num='$fa[num]'");

		}

		

	}

	if ( ( ( $def_onlypaid == "YES" ) and ( $flag == "D" ) ) or ( $$exel_enabled != "YES" ) )

	$exelSQL = ", exel = 0";

	else

	$exelSQL = ", exel = " . $$set_exel;

	
	$ra = mysql_query ( "SELECT * FROM $db_video where firmselector = $selector order by num" );
	if (!$ra) error ("mySQL error", mysql_error() );

	$results_amount_video = mysql_num_rows ( $ra );

	if ( (( $def_onlypaid == "YES" ) and ( $flag == "D") ) or ($$video_enabled != "YES") or ( $results_amount_video > $$set_video ) )

	{

		$del_video=$results_amount_video-$$set_video;

		for ( $i2=0; $i2<$del_video; $i2++ )

		{

			$fa = mysql_fetch_array ( $ra );

			mysql_query("DELETE FROM $db_video where firmselector='$selector' and num='$fa[num]'");

		}		

	}

	if ( ( ( $def_onlypaid == "YES" ) and ( $flag == "D" ) ) or ( $$video_enabled != "YES" ) )

	$videoSQL = ", video = 0";

	else

	$videoSQL = ", video = " . $$set_video;


	$ra = mysql_query ( "SELECT * FROM $db_offers where firmselector = $selector order by num" );
	if ( !$ra ) error ( "mySQL Error", mysql_error() );

	$results_amount_products = mysql_num_rows ( $ra );

	if ( ( ( $def_onlypaid == "YES" ) and ($flag == "D") ) or ( $results_amount_products > $$set_products ) )

	{

		$del_products=$results_amount_products-$$set_products;

		for ( $i3=0; $i3<$del_products; $i3++ )

		{

			$fa = mysql_fetch_array ( $ra );

			@unlink($folder . "./offer/$fa[num].gif");
			@unlink($folder . "./offer/$fa[num].bmp");
			@unlink($folder . "./offer/$fa[num].jpg");
			@unlink($folder . "./offer/$fa[num].png");

			@unlink($folder . "./offer/$fa[num]-small.gif");
			@unlink($folder . "./offer/$fa[num]-small.bmp");
			@unlink($folder . "./offer/$fa[num]-small.jpg");
			@unlink($folder . "./offer/$fa[num]-small.png");

			mysql_query("DELETE FROM $db_offers where firmselector='$selector' and num='$fa[num]'");

		}

	}


	if ( ( ( $def_onlypaid == "YES" ) and ( $flag == "D" ) ) or ( $$products_enabled != "YES" ) )

	$productSQL = ", prices = 0";

	else

	$productSQL = ", prices = " . $$set_products;


	$ra = mysql_query ( "SELECT * FROM $db_info where firmselector = $selector order by date, datetime" );
	if (!$ra) error ("mySQL error", mysql_error() );

	$results_amount_info = mysql_num_rows ( $ra );

	if ( (( $def_onlypaid == "YES" ) and ( $flag == "D") ) or ($$info_enabled != "YES") or ( $results_amount_info > $$set_info ) )

	{

		$del_info=$results_amount_info-$$set_info;

		$kInfo=$f[info];
		$kNews=$f[news];
		$kTender=$f[tender];
		$kBoard=$f[board];
		$kJob=$f[job];
		$kPressrel=$f[pressrel];

		for ( $i2=0; $i2<$del_info; $i2++ )

		{

			$fa = mysql_fetch_array ( $ra );
			
			$kInfo=$kInfo-1;

			if ($fa[type]==1) $kNews=$kNews-1;
			if ($fa[type]==2) $kTender=$kTender-1;
			if ($fa[type]==3) $kBoard=$kBoard-1;
			if ($fa[type]==4) $kJob=$kJob-1;
			if ($fa[type]==5) $kPressrel=$kPressrel-1;


			@unlink($folder . "./info/$fa[num].gif");
			@unlink($folder . "./info/$fa[num].bmp");
			@unlink($folder . "./info/$fa[num].jpg");
			@unlink($folder . "./info/$fa[num].png");

			@unlink($folder . "./info/$fa[num]-small.gif");
			@unlink($folder . "./info/$fa[num]-small.bmp");
			@unlink($folder . "./info/$fa[num]-small.jpg");
			@unlink($folder . "./info/$fa[num]-small.png");

			mysql_query("DELETE FROM $db_info where firmselector='$selector' and num='$fa[num]'");

		}

		$infoSQL = ", info = '$kInfo', news = '$kNews', tender = '$kTender', board = '$kBoard', job = '$kJob', pressrel = 'kPressrel' ";

	}

	else $infoSQL="";


	if ($flag != "D")

	$date_upgrade = date ("Y-m-d");

	else

	$date_upgrade = "0";

	$date_changed = date ("Y-m-d");

	mysql_query ( "UPDATE $db_users SET flag='$flag', comment='Membership downgraded automatically from $f[flag] to $flag on $date_changed', date_upgrade='$date_upgrade' $productSQL $imageSQL $exelSQL $videoSQL $infoSQL WHERE selector='$selector'" ) or die (mysql_error());

}


function update_categories ($oldflag, $flag, $oldcategories, $newcategories, $section)

{

	global $db_category;
	global $db_subcategory;
	global $db_subsubcategory;

	if ($section == "admin") $folder = "../"; else $folder = "";

	include ($folder . "./conf/memberships.php");


 	if ( ( ( $def_onlypaid == "YES" ) and ($oldflag != "D") ) or ( $def_onlypaid != "YES" ) )


	{

		$category = explode (":", $oldcategories);

		for ($index = 0; $index < count ( $category ); $index++)

		{


			$new_cat = explode ("#", $category[$index]);

			if ( $new_cat[0] != $prev_cat )

			mysql_query ("UPDATE $db_category SET fcounter = fcounter-1 where selector=$new_cat[0]");

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

			mysql_query ("UPDATE $db_subcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]");

			if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

			mysql_query ("UPDATE $db_subsubcategory SET fcounter = fcounter-1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]");

			$prev_cat=$new_cat[0];
			$prev_subcat=$new_cat[1];

		}

	}

unset($prev_cat);
unset($prev_subcat);

	$index_category = 1;

	for ($index = 0; $index < count ( $newcategories ); $index++)

	{

		if ($newcategories[$index] != "") {

			$category_index[$index_category] = $newcategories[$index];$index_category++;


			if ( ( ( $def_onlypaid == "YES" ) and ( $flag != "D" ) ) or ( $def_onlypaid != "YES" ) )

			{


				$new_cat = explode ("#", $newcategories[$index]);

				if ($new_cat[0] != $prev_cat)

				mysql_query ("UPDATE $db_category SET fcounter = fcounter+1 where selector=$new_cat[0]");

				if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[1] != $prev_subcat))

				mysql_query ("UPDATE $db_subcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1]");

				if (($new_cat[1] != "") and ($new_cat[1] != "0") and ($new_cat[2] != "") and ($new_cat[2] != "0"))

				mysql_query ("UPDATE $db_subsubcategory SET fcounter = fcounter+1 where catsel=$new_cat[0] and catsubsel=$new_cat[1] and catsubsubsel=$new_cat[2]");

			}

			$prev_cat=$new_cat[0];
			$prev_subcat=$new_cat[1];

		}

	}

	@ $category = join(":", $category_index);

	return $category;

}


?>