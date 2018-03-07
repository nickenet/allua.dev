<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: alpha.php
-----------------------------------------------------
 Назначение: Вывод организации по первой букве
=====================================================
*/

 $kPage=intval($_GET['page']);

 $npage = $kPage + 1;
 $ppage = $kPage - 1;
 $page1 = $kPage * $def_count_dir;

$lowercase=strtolower($kLetter);
$uppercase=strtoupper($kLetter);

  if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

  $r1 = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE (( firmname LIKE '$lowercase%' ) or ( firmname LIKE '&quot;$lowercase%' ) or ( firmname LIKE '$uppercase%' ) or ( firmname LIKE '&quot;$uppercase%' )) and firmstate='on' $hide_d $_SESSION[where_city]" );
  $result_in=mysql_result($r1,0,0);

  $r = $db->query ( "SELECT * FROM $db_users WHERE (( firmname LIKE '$lowercase%' ) or ( firmname LIKE '&quot;$lowercase%' ) or ( firmname LIKE '$uppercase%' ) or ( firmname LIKE '&quot;$uppercase%' )) and firmstate='on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_srch" );
  $results_amount=$db->numrows($r);

  $r_filter = $db->query ( "SELECT mobile, map FROM $db_users WHERE (( firmname LIKE '$lowercase%' ) or ( firmname LIKE '&quot;$lowercase%' ) or ( firmname LIKE '$uppercase%' ) or ( firmname LIKE '&quot;$uppercase%' )) and firmstate='on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_srch" );

?>

<div style="text-align:center;">
<form>
    <input type="hidden" name="select value">
		<select name="sel" size="1" class="input-search" OnChange="top.location.href = this.options[this.selectedIndex].value;">
			<?php
				$letters = explode("#", $def_index_search);
				for ($a=0;$a<count($letters);$a++)
				{
				echo "<option value=\"$def_mainlocation_pda/index.php?letter=$letters[$a]\">$letters[$a]</option>";
				}
			?>
		</select>
</form>
</div>
<br />
<p><? echo $def_search.': '.$kLetter; ?></p>

<?

if ($def_count_srch > $results_amount) $fetchcounter = $results_amount; else $fetchcounter = $def_count_srch;

  $f = $result_in - $page1;
  if ( $f < $def_count_srch ) $fetchcounter = $result_in - $page1;

       include ("./includes/sub.php");

if ( $result_in > $def_count_srch ) {

    echo '<div class="pagination"><ul>';

	if ((($kPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($kPage*$def_count_srch)+($def_count_srch*6)) <= $result_in) $last =($kPage*$def_count_srch)+($def_count_srch*6);
	else $last = $result_in;

	@    $z=$first/$def_count_srch;

	if ($kPage > 0) echo "<li><a href=\"index.php?letter=$kLetter&amp;page=", $kPage-1 ,"\">$def_previous</a></li>";

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_count_srch )

	{
		if ( $z == $kPage )

		{
			echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
			$z++;
		}

		else

		{
			echo "<li><a href=\"index.php?letter=$kLetter&amp;page=", $z ,"\">", $z+1 ,"</a></li>";
			$z++;
		}
	}

	if ($kPage - (($result_in / $def_count_srch) - 1) < 0) echo "<li><a href=\"index.php?letter=$kLetter&amp;page=", $kPage+1 ,"\">$def_next</a></li>";

        echo '</ul></div>';
}

$db->freeresult ( $r );

?>
