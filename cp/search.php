<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search.php
-----------------------------------------------------
 Назначение: Расширенный поиск компании
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$search_help;

$title_cp = 'Расширенный поиск компании - ';
$speedbar = ' | <a href="search.php?REQ=auth">Расширенный поиск компании</a>';

check_login_cp('1_2','search.php?REQ=auth');

require_once 'template/header.php';


		if (!isset($_GET[search]))

		{

?>

<table width="100%" border="0">
  <tr>
    <td><img src="images/find.png" width="32" height="32" align="absmiddle" /><span class="maincat"><?php echo "$def_search"; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34" /></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="160" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" /><a href="find.php?REQ=auth">Быстрый поиск</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<center>
<form name="search" action="search.php?REQ=auth&search=on" method=post>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files"><?php echo "$def_admin_uslovie"; ?></td>
        <td id="table_files_r"><?php echo "$def_admin_forma_find"; ?></td>
        </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_category"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r">
     <SELECT NAME="category" style="width:316px;">

 <?php                                                                                                                                                                                                                                                                                             

 echo "<OPTION VALUE=\"ANY\">$def_any_category";

 $r = $db->query  ( "SELECT * FROM $db_category ORDER BY category" );
 $results_amount = mysql_num_rows ( $r );

 for ( $i=0; $i < $results_amount; $i++ )

 {

 	$f = $db->fetcharray  ( $r );

 	$ra = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsel=$f[selector] ORDER BY subcategory" );
 	$results_amount2 = mysql_num_rows ( $ra );

 	if ( ($results_amount2 == 0) ) $results_amount2 = 1;

 	for ( $j=0; $j < $results_amount2; $j++)

 	{

 		$fa = $db->fetcharray  ( $ra );
 		$raa = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel=$f[selector] and catsubsel=$fa[catsubsel] ORDER BY subsubcategory" );
 		@      $results_amount3 = mysql_num_rows ( $raa );

 		if (($results_amount3 == 0) and ($results_amount2 == 0)) $results_amount3 = 1;
 		if (($results_amount3 == 0) and ($results_amount2 != 0)) $results_amount3 = 1;

 		for ( $k=0; $k < $results_amount3; $k++ )

 		{

 			@      $faa = $db->fetcharray  ( $raa );

 			if ( ( !isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

 			echo "<OPTION VALUE=\"$f[selector]#0#0\">$f[category]";

 			if ( ( isset($fa[catsubsel]) ) and ( !isset($faa[catsubsubsel]) ) )

 			echo "<OPTION VALUE=\"$f[selector]#$fa[catsubsel]#0\">$f[category] :: $fa[subcategory]";

 			if ( ( isset($fa[catsubsel]) ) and ( isset($faa[catsubsubsel]) ) )

 			echo "<OPTION VALUE=\"$f[selector]#$fa[catsubsel]#$faa[catsubsubsel]\">$f[category] :: $fa[subcategory] :: $faa[subsubcategory]";

 		}

 	}

 }

 @  mysql_free_result ( $r );
 @  mysql_free_result ( $ra );
 @  mysql_free_result ( $raa );

 echo "</SELECT>";

?>
          </td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_title"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="firmname" size="50" maxlength="100"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="250" id="table_files_i"><?php if ( $def_country_allow == "YES" ) echo "$def_admin_country"; else echo "$def_admin_city"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r">
<SELECT NAME="location" style="width:316px;">
<?php

echo "<OPTION VALUE=\"ANY\">$def_any_location";

$r = $db->query  ( "SELECT * FROM $db_location ORDER BY location" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++ )

{

	$f = $db->fetcharray  ( $r );
	echo "<OPTION VALUE=\"$f[locationselector]\">$f[location]";

}

mysql_free_result ( $r );
echo "</SELECT>
	  </td>
        </tr>
";

if ( $def_states_allow == "YES" )

{

?>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_state"; ?>: </td>
          <td class="blue_txt" id="table_files_i_r">
     <SELECT NAME="state" style="width:316px;">
<?php                                                                                                                                                                                                                                                                                             

echo "<OPTION VALUE=\"ANY\">$def_any_state";

$r = $db->query  ( "SELECT * FROM $db_states ORDER BY state" );
$results_amount = mysql_num_rows ( $r );

for ( $i=0; $i < $results_amount; $i++)

{

	$f = $db->fetcharray  ( $r );
	echo "<OPTION VALUE=\"$f[stateselector]\">$f[state]";

}

mysql_free_result ( $r );
echo "</SELECT>
	  </td>
        </tr>
";
}

if ( $def_country_allow == "YES" )

{

?>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_city"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="city" size="50" maxlength="100"></td>
        </tr>

<?php

}

?>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_zip"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="zip" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_mail"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="mail" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_search_sort_membership"; ?>:</td>
          <td class="blue_txt" id="table_files_i_r">
<?
echo "<SELECT NAME=\"membership\" style=\"width:316px;\">";

echo "<OPTION VALUE=\"ANY\">$def_all_memberships";

if ($def_A_enable == "YES")
echo "<OPTION VALUE=\"A\">$def_A";

if ($def_B_enable == "YES")
echo "<OPTION VALUE=\"B\">$def_B";

if ($def_C_enable == "YES")
echo "<OPTION VALUE=\"C\">$def_C";

echo "<OPTION VALUE=\"D\">$def_D";

echo "</SELECT>";

?>
	  </td>
        </tr>
        <tr>
          <td width="250" id="table_files_i"><?php echo "$def_admin_loch_m_find:"; ?></td>
          <td class="blue_txt" id="table_files_i_r"><select name="on_memberships"><option value="0" selected><?php echo "$def_admin_no"; ?></option><option value="1"><?php echo "$def_admin_yes"; ?></option></select></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i">
    <?php echo "$def_sort";?>:<br>
    <?php echo "<input type=radio name=sort value=\"1\" style=\"border:0px;\" CHECKED>- $def_search_sort_company"; ?><br>
    <?php echo "<input type=radio name=sort value=\"2\" style=\"border:0px;\">- $def_search_sort_membership"; ?><br>
    <?php echo "<input type=radio name=sort value=\"3\" style=\"border:0px;\">- $def_search_sort_date_1"; ?><br>
    <?php echo "<input type=radio name=sort value=\"4\" style=\"border:0px;\">- $def_search_sort_date_2"; ?><br>
	  </td>
        </tr>
      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type="submit" name="regbut" value="<?php echo "$def_admin_search_button"; ?>" border="0"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>

<?


		}

		else

		{

			if ( $_GET["firmname"] <> "" )
			{
				$firmname = rawurldecode ( $_GET["firmname"] );
			}
			else
			{
				$firmname = "$_POST[firmname]";
				$firmname = safehtml($firmname);
			}


			if ( $_GET["category"] <> "" )
			{
				$category = rawurldecode ( $_GET["category"] );
			}
			else
			{
				$category = "$_POST[category]";
				$category = safehtml($category);
			}

			if ( $_GET["location"] <> "" )
			{
				$location = rawurldecode ( $_GET["location"] );
			}
			else
			{
				$location = "$_POST[location]";
				$location = safehtml($location);
			}


			if ( $_GET["state"] <> "" )
			{
				$state = rawurldecode ( $_GET["state"] );
			}
			else
			{
				$state = "$_POST[state]";
				$state = safehtml($state);
			}

			if ( $_GET["membership"] <> "" )
			{
				$membership = rawurldecode ( $_GET["membership"] );
			}
			else
			{
				$membership = "$_POST[membership]";
				$membership = safehtml($membership);
			}

			if ( $_GET["sort"] <> "" )
			{
				$sort = rawurldecode ( $_GET["sort"] );
			}
			else
			{
				$sort = "$_POST[sort]";
			}

			if ( $_GET["city"] <> "" )
			{
				$city = rawurldecode ( $_GET["city"] );
			}
			else
			{
				$city = "$_POST[city]";
				$city = safehtml($city);
			}

			if ( $_GET["mail"] <> "" )
			{
				$mail = rawurldecode ( $_GET["mail"] );
			}
			else
			{
				$mail = "$_POST[mail]";
				$mail = safehtml($mail);
			}

			if ( $_GET["zip"] <> "" )
			{
				$zip = rawurldecode ( $_GET["zip"] );
			}
			else
			{
				$zip = "$_POST[zip]";
				$zip = safehtml($zip);
			}

			if ( $_GET["on_memberships"] <> "" )
			{
				$on_memberships = rawurldecode ( $_GET["on_memberships"] );
			}
			else
			{
				if ($_POST[on_memberships]!=1) $on_memberships = (int)$_POST[on_memberships]; else $on_memberships="";
			}

			$npage = $_GET["spage"] + 1;
			$ppage = $_GET["spage"] - 1;
			$page1 = $_GET["spage"] * $def_count_srch;

			$query .= " FROM $db_users WHERE ";

			$query .= " firmstate='on' ";

			if ( $category != "ANY" )

			{

				$query .= " AND ((category LIKE '$category') or (category LIKE '%:$category:%') or (category LIKE '$category:%') or (category LIKE '%:$category')) ";

			}

			if ( $firmname != "" )

			{

				$query .= " AND firmname LIKE '%$firmname%' ";

			}

			if ( $location != "ANY" )

			{

				$query .= " AND location = '$location' ";

			}

			if ( $def_states_allow == "YES" )

			{

				if ( $state != "ANY" )

				{

					$query .= " AND state = '$state' ";

				}

			}

			if ( $def_country_allow == "YES" )

			{

				if ( $city != "" )

				{

					$query .= " AND city LIKE '%$city%' ";

				}

			}

			if ( $zip != "" )

			{

				$query .= " AND zip LIKE '%$zip%' ";

			}

			if ( $on_memberships != "" )

			{

				$query .= " AND loch_m LIKE '%$on_memberships%' ";

			}

			if ( $mail != "" )

			{

				$query .= " AND mail LIKE '%$mail%' ";

			}

			if ( $membership != "ANY" )

			{

				$query .= " AND flag = '$membership' ";

			}

			if ($sort == "1")
			$query .= " ORDER BY firmname ";

			if ($sort == "2")
			$query .= " ORDER BY flag ";

			if ($sort == "3")
			$query .= " ORDER BY date ";

			if ($sort == "4")
			$query .= " ORDER BY date DESC ";

			$ra = $db->query  ( "SELECT COUNT(*) $query" );
			$results_amount = mysql_result ( $ra, 0, 0 );
			@mysql_free_result ( $ra );

			$rr = $db->query  ( "SELECT * $query LIMIT $page1, $def_count_srch");
			$results_amount2 = mysql_num_rows ( $rr );
			$fetchcounter = $def_count_srch;


echo <<<HTML

<table width="100%" border="0">
  <tr>
    <td><img src="images/find.png" width="32" height="32" align="absmiddle"><span class="maincat">$def_search</span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
</table>
HTML;
echo "<center><br>
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"97%\">
         <tr>
          <td align=\"left\" valign=\"middle\" width=\"60%\" id=\"table_files\">
           $def_admin_title - $def_admin_descr
          </td>
          <td align=\"left\" valign=\"middle\" width=\"20%\" id=\"table_files_c\">
            $def_admin_location
          </td>
          <td align=\"left\" valign=\"middle\" width=\"20%\" id=\"table_files\">
            $def_admin_registered / $def_admin_upgraded / $def_expiration_date
          </td>
         </tr>";
			if ($def_count_srch > $results_amount2) $results_amount_output = $results_amount2;
			else $results_amount_output = $def_count_srch;

			for ( $zz=0; $zz < $results_amount_output; $zz++ )

			{

				$fa = $db->fetcharray  ( $rr );
				$id = $fa["selector"];

				$date_day = date ( "d" );
				$date_month = date ( "m" );
				$date_year = date ( "Y" );

				list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $fa["date"] );

				$first_date = mktime (0,0,0,$on_month,$on_day,$on_year );
				$second_date = mktime (0,0,0,$date_month,$date_day,$date_year );

				if ( $second_date > $first_date )

				{

					$days = $second_date - $first_date;

				}

				else

				{

					$days = $first_date - $second_date;

				}

				$current_result = round (( $days ) / ( 60 * 60 * 24 ));

				if ( $zz%2 == 0 )

				{

					$color = "#F3F3F3";

				}

				else

				{

					$color = "#FFFFFF";

				}

				if ( $fa["flag"] == "A" )

				{

					$color = "$def_form_back_color_premium";

				}

				$ree = $db->query  ( "SELECT location FROM $db_location WHERE locationselector='$fa[location]'" );
				$fee = $db->fetcharray  ( $ree );

				$rii = $db->query  ( "SELECT state FROM $db_states WHERE stateselector='$fa[state]'" );
				$fii = $db->fetcharray  ( $rii );

				$raa = $db->query  ( "SELECT * FROM $db_offers where firmselector='$fa[selector]'" );
				@$price_results_amount = mysql_num_rows ( $raa );

				$raa2 = $db->query  ( "SELECT * FROM $db_images where firmselector='$fa[selector]'" );
				@$images_results_amount = mysql_num_rows ( $raa2 );

				$raa3 = $db->query  ( "SELECT * FROM $db_exelp where firmselector='$fa[selector]'" );
				@$exel_results_amount = mysql_num_rows ( $raa3 );

				$raa4 = $db->query  ( "SELECT * FROM $db_video where firmselector='$fa[selector]'" );
				@$video_results_amount = mysql_num_rows ( $raa4 );

				if ( $current_result <= 5 )

				{

					$new_listing = "$def_new";

				}

				else

				{

					$new_listing = "";

				}

				if ( ( $fa[countrating] == 5 ) and ( $fa[votes] > 5 ) )

				{

					$hot_listing = "$def_hot";

				}

				else

				{

					$hot_listing = "";

				}

				unset ( $rating_listing );


				if ( $price_results_amount > 0 ) $offers_link = "$def_offers_mark"; else $offers_link = "";

				if ( $images_results_amount > 0 ) $images_link = "$def_images_mark"; else $images_link="";

				if ( $exel_results_amount > 0 ) $exel_link = "$def_exel_mark"; else $exel_link = "";

				if ( $video_results_amount > 0 ) $video_link = "$def_video_mark"; else $video_link="";

				if ( $fa[info] > 0 ) $info_link = "$def_info_mark"; else $info_link="";


				if ( ( ( $fa[flag] == "D" ) and ( $def_D_description == "YES" ) ) or ( ( $fa[flag] == "C" ) and ( $def_C_description == "YES" ) ) or ( ( $fa[flag] == "B" ) and ( $def_B_description == "YES" ) ) or ( ( $fa[flag] == "A" ) and ( $def_A_description == "YES" ) ) )

				{

					if (!empty($fa["business"]))
					{
						$descr="<br><br>";
						$descr.= substr ( strip_tags($fa["business"]), 0, 150 );
						if ( strlen ( strip_tags($fa[business]) ) >= 150 ) $descr.= "...";
					}

					else

					$descr = "";

				}

				else

				{

					$descr = "";

				}

				$location2 = "$fee[location]";

				if ( $def_states_allow == "YES" )

				$location2.= ",<br>$fii[state]";

				if ( $def_country_allow == "YES" )

				$location2.= ",<br>$fa[city]";

				$date_day = date ( "d" );
				$date_month = date ( "m" );
				$date_year = date ( "Y" );

IF ($fa["date_upgrade"]<>""){				

list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $fa["date_upgrade"] );

				$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
				$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

				if ( $second_date > $first_date )

				{ $days = $second_date - $first_date; }

				else

				{ $days = $first_date - $second_date; }

				if ($fa[flag] == "A") $expir = $def_A_expiration;
				if ($fa[flag] == "B") $expir = $def_B_expiration;
				if ($fa[flag] == "C") $expir = $def_C_expiration;

				$current_result2 = $expir - ( ( $days ) / ( 60 * 60 * 24 ) );

				if ($fa[flag] != "D")
				{
					$exp=getdate (time()+86400*$current_result2);
					$exp2="$exp[year]-$exp[mon]-$exp[mday]";
				}
}


				if (($fa["date_upgrade"] != "0") and ($expir != "0") and (!empty($fa["date_upgrade"])) and ($fa[flag] != "D")) $upgrade = " / <br>". undate($fa[date_upgrade], $def_datetype) ." / <br>". undate($exp2, $def_datetype) ." <br><br>(<b>$current_result2</b> $days_left) "; else $upgrade = "";



				echo "<tr><td align=\"left\" valign=\"middle\" bgcolor=\"$color\" id=\"table_files_i\">";

				echo "<a href=\"offers.php?REQ=auth&amp;id=$id\" class=\"vclass\">";

				if ($fa["flag"] == "A") $listingtype="$def_A";
				if ($fa["flag"] == "B") $listingtype="$def_B";
				if ($fa["flag"] == "C") $listingtype="$def_C";
				if ($fa["flag"] == "D") $listingtype="$def_D";

				$date_day = date ( "d" );
				$date_month = date ( "m" );
				$date_year = date ( "Y" );

IF ($fa["date_update"]<>""){
				list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $fa["date_update"] );

				$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
				$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

				if ( $second_date > $first_date )

				{

					$days = $second_date - $first_date;

				}

				else

				{

					$days = $first_date - $second_date;

				}

				$current_result = ( $days ) / ( 60 * 60 * 24 );

				if ( $current_result <= 5 )

				{

					$updated_listing = "$def_updated";

				}

				else

				{

					$updated_listing = "";

				}
}
else
{
$updated_listing = "";
}

				echo "<b><u>$fa[firmname]</u></b></a>&nbsp; $new_listing $updated_listing $hot_listing $offers_link $images_link $exel_link $video_link $info_link &nbsp;&nbsp;$descr<br>

<br>

$def_membership: $listingtype ($fa[flag])<br>
$def_admin_manager: $fa[manager]<br>
$def_admin_phone: $fa[phone]<br>
$def_admin_mail: <a href=mailto:$fa[mail] class=\"slink\">$fa[mail]</a><br>
$def_admin_www: <a href=$fa[www] class=\"slink\">$fa[www]</a><br>

" , show_rating($fa[rating], $fa[votes]) , "

</td><td align=left valign=middle bgcolor=$color id=\"table_files_i_c\">$location2<br><br>$fa[zip]<br>$fa[address]</td><td align=left valign=middle bgcolor=$color id=\"table_files_i\">", undate($fa[date], $def_datetype)," $upgrade </td></tr>";

			}

			echo "</table><br>";


			if ( $results_amount == 0 )

			{

			$def_nothing_found= "$def_nothing_found<br><br><a href=\"javascript:history.back()\">$def_back</a>";

			msg_text("80%",$def_admin_message_error,$def_nothing_found);

			}

			$category2 = rawurlencode ( $category );
			$firmname2 = rawurlencode ( $firmname );
			$location2 = rawurlencode ( $location );
			$state2 = rawurlencode ( $state );
			$city2 = rawurlencode ( $city );
			$zip2 = rawurlencode ( $zip );
			$mail2 = rawurlencode ( $mail );
			$membership2 = rawurlencode ( $membership );
			$sort2 = rawurlencode ( $sort );

if ( $results_amount > $def_count_srch )

{

			if ($_GET["spage"] > 0)

			echo "<a href=\"search.php?REQ=auth&amp;search=on&amp;category=$category2&amp;firmname=$firmname2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;zip=$zip2&amp;mail=$mail2&amp;membership=$membership2&amp;sort=$sort2&amp;spage=", $_GET[spage]-1 ,"&amp;page=$_GET[page]\" class=\"vclass\"><b>$def_previous</b></a>&nbsp;";

$z = 0;

	for ( $x=0; $x < $results_amount; $x=$x+$def_count_srch )

	{

		if ( $z == $_GET["spage"] )

		{

			echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
			$z++;

		}

		else

		{

			echo "<a href=\"search.php?REQ=auth&amp;search=on&amp;category=$category2&amp;firmname=$firmname2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;zip=$zip2&amp;mail=$mail2&amp;membership=$membership2&amp;sort=$sort2&amp;spage=$z&amp;page=$_GET[page]\" class=\"vclass\"><b>", $z+1 ,"</b></a>&nbsp;";
			$z++;

		}

	}


	if ($_GET[spage] - (($results_amount / $def_count_srch) - 1) < 0)

			echo "<a href=\"search.php?REQ=auth&amp;search=on&amp;category=$category2&amp;firmname=$firmname2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;zip=$zip2&amp;mail=$mail2&amp;membership=$membership2&amp;sort=$sort2&amp;spage=", $_GET[spage]+1 ,"&amp;page=$_GET[page]\" class=\"vclass\"><b>$def_next</b></a>";

}


		}

require_once 'template/footer.php';

?>
