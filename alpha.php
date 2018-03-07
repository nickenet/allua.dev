<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: alpha.php
-----------------------------------------------------
 Назначение: Вывод организации по первой букве
=====================================================
*/


 include ("./defaults.php");

 $npage = $_GET["page"] + 1;
 $ppage = $_GET["page"] - 1;
 $page1 = $_GET["page"] * $def_count_srch;


 $lowercase=strtolower($_GET[letter]);
 $uppercase=strtoupper($_GET[letter]);

 $kLetter=safeHTML ($_GET[letter]);

 if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

 if ($kLetter!="0-9") {

 $r1 = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE (( firmname LIKE '$lowercase%' ) or ( firmname LIKE '&quot;$lowercase%' ) or ( firmname LIKE '$uppercase%' ) or ( firmname LIKE '&quot;$uppercase%' )) and firmstate='on' $hide_d " );

 $result_in=mysql_result($r1,0,0);

 $r = $db->query ( "SELECT * FROM $db_users WHERE (( firmname LIKE '$lowercase%' ) or ( firmname LIKE '&quot;$lowercase%' ) or ( firmname LIKE '$uppercase%' ) or ( firmname LIKE '&quot;$uppercase%' )) and firmstate='on' $hide_d ORDER BY flag, firmname LIMIT $page1, $def_count_srch" );
 $results_amount=$db->numrows($r);

 }

 else {

 $r1 = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE (( firmname LIKE '0%' ) or ( firmname LIKE '1%' ) or ( firmname LIKE '2%' ) or ( firmname LIKE '3%' ) or ( firmname LIKE '4%' ) or ( firmname LIKE '5%' ) or ( firmname LIKE '6%' ) or ( firmname LIKE '7%' ) or ( firmname LIKE '8%' ) or ( firmname LIKE '9%' )) and firmstate='on' $hide_d " );

 $result_in=mysql_result($r1,0,0);

 $r = $db->query ( "SELECT * FROM $db_users WHERE (( firmname LIKE '0%' ) or ( firmname LIKE '1%' ) or ( firmname LIKE '2%' ) or ( firmname LIKE '3%' ) or ( firmname LIKE '4%' ) or ( firmname LIKE '5%' ) or ( firmname LIKE '6%' ) or ( firmname LIKE '7%' ) or ( firmname LIKE '8%' ) or ( firmname LIKE '9%' )) and firmstate='on' $hide_d ORDER BY flag, firmname LIMIT $page1, $def_count_srch" );
 $results_amount=$db->numrows($r);

 }


 $incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$def_search: $kLetter</font>";

 $help_section = "$cat_help_4";

 $incomingline_firm = "$def_search: $kLetter";

 include ( "./template/$def_template/header.php" );

 if ($def_allow_index == "YES") 

 {

 ?>

  <table cellpadding="0" cellspacing="0" border="0" width="100%">
   <tr>
    <td valign="middle" align="center" width="100%">

<?php

   $letters = explode("#", $def_index_search);

   echo "<br>";
 
   for ($a=0;$a<count($letters);$a++)

    {

     echo "<a href=\"$def_mainlocation/alpha.php?letter=$letters[$a]\"><u>$letters[$a]</u></a>&nbsp;&nbsp;";

    }

   echo "<br><br>";
     
?>

    </td>
   </tr>
  </table>

<?php } 

if ($def_count_srch > $results_amount) $fetchcounter = $results_amount;
else $fetchcounter = $def_count_srch;

  $f = $result_in - $page1;
  if ( $f < $def_count_srch ) $fetchcounter = $result_in - $page1;

       include ("./includes/sub.php");

if ( $result_in > $def_count_srch )

{

	if ((($kPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($kPage*$def_count_srch)+($def_count_srch*6)) <= $result_in) $last =($kPage*$def_count_srch)+($def_count_srch*6);
	else $last = $result_in;

	@    $z=$first/$def_count_srch;

	if ($_GET["page"] > 0)

{

     echo "<a href=\"alpha.php?letter=$kLetter&amp;page=", $kPage-1 ,"\"><b>$def_previous</b></a>&nbsp;";

}

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_count_srch )

	{

		if ( $z == $kPage )

		{

			echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
			$z++;

		}

		else

		{

     echo "<a href=\"alpha.php?letter=$kLetter&amp;page=", $z ,"\"><b>", $z+1 ,"</b></a>&nbsp;";

			$z++;

		}

	}



	if ($kPage - (($result_in / $def_count_srch) - 1) < 0)
{

     echo "<a href=\"alpha.php?letter=$kLetter&amp;page=", $kPage+1 ,"\"><b>$def_next</b></a>&nbsp;";

}

}

	echo "<br><br>";


   $db->freeresult ( $r );

   include ( "./template/$def_template/footer.php" );

?>
