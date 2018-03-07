<?php /*

Шаблон вывода категорий на главной странице

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
  <br /><br />
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
   <tr>
    <td width="100%" valign="top" align="center">
     <table cellspacing="0" cellpadding="0" border="0" width="90%">
      <tr>
       <td width="50%" valign="top" align="left">
 <?php 

 // количество столбиков вывода категорий
 $res = round ( $results/2 );

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );

        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top" class="hidden-xs">'.imgM_Cat($f['img'],$f['selector']).'</td>';
        echo '<td align="left" valign="top">';

 	if ( $f['fcounter'] > 0 )

 	{	
 		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($f['category']).'/'. $f['selector'].'-0.html">';
                else echo '<a href="'.$def_mainlocation.'/index.php?category='.$f['selector'].'">';

                echo '<span class="maincat">'.$f['category'].'</a> &#187 </span>';

		echo '<div class="hidden-xs">';

                if ($def_show_indexes == "YES") {
                    echo '<span class=count>';
                    if (($f['sccounter'] != 0) and ($f['ssccounter'] != 0)) echo "[$f[sccounter]/$f[ssccounter]/$f[fcounter]]";
                    if (($f['sccounter'] != 0) and ($f['ssccounter'] == 0)) echo "[$f[sccounter]/$f[fcounter]]";
                    if (($f['sccounter'] == 0) and ($f['ssccounter'] == 0)) echo "[$f[fcounter]]";
                    echo '</span>';
                }
                       if ($def_show_subcategories == "YES") {
                           if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0"; else $sql = "";

                           $r_subs = $db->query("SELECT catsubsel, subcategory, fcounter FROM $db_subcategory WHERE catsel='$f[selector]' $sql ORDER BY subcategory LIMIT $def_show_subs_number");
                           $results2 = $db->numrows($r_subs);

                           if ($results2 > 0) echo "<br>";

                           for ($i2 = 0; $i2 < $results2; $i2++) {

                               $f_subs = $db->fetcharray($r_subs);

                               if ($f_subs['fcounter'] > 0) {

                                   if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($f['category']).'/'. rewrite($f_subs['subcategory']).'/'. $f['selector']. '-'.$f_subs['catsubsel'].'-0.html">';
                                   else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$f['selector'].'&subcat='.$f_subs['catsubsel'].'">';

                                   echo '<span class="subcat">'.$f_subs['subcategory'].'</span></a>';

                                   if ($def_show_indexes == "YES") echo ' <span class="count">['.$f_subs['fcounter'].']</span>';

                                                if ($results2 > $i2 + 1) echo ', ';
                                }
                                else {

                                    echo ' <span class="emptycat2">'.$f_subs['subcategory'].'</span>';

                                                if ($results2 > $i2 + 1) echo ', ';
                                }
                           }
                                if ($results2 > 0) echo "<br>";
                       }
        }

        else { echo '<span class="emptycat">'.$f['category'].'</span>'; }

	echo '</div>';

        echo '</td></tr></table><br>';
}
?>
        <br /><br />
       </td>
       <td width="50%" valign="top" align="left">
<?php

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );

        echo '<table border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td align="right" valign="top" class="hidden-xs">'.imgM_Cat($f['img'],$f['selector']).'</td>';
        echo '<td align="left" valign="top">';

 	if ( $f['fcounter'] > 0 )

 	{
 		if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($f['category']).'/'.$f['selector'].'-0.html">';
                else echo '<a href="'.$def_mainlocation.'/index.php?category='.$f['selector'].'">';

                echo '<span class="maincat">'.$f['category'].'</a> &#187 </span>';

		echo '<div class="hidden-xs">';

                if ($def_show_indexes == "YES") {
                    echo '<span class=count>';
                        if (($f['sccounter'] != 0) and ($f['ssccounter'] != 0)) echo "[$f[sccounter]/$f[ssccounter]/$f[fcounter]]";
                        if (($f['sccounter'] != 0) and ($f['ssccounter'] == 0)) echo "[$f[sccounter]/$f[fcounter]]";
                        if (($f['sccounter'] == 0) and ($f['ssccounter'] == 0)) echo "[$f[fcounter]]";
                    echo '</span>';
                }

                       if ($def_show_subcategories == "YES") {
                            if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0"; else $sql = "";

                           $r_subs = $db->query("SELECT catsubsel, subcategory, fcounter FROM $db_subcategory WHERE catsel='$f[selector]' $sql ORDER BY subcategory LIMIT $def_show_subs_number");
                           if (!$r_subs) error("mySQL error", mysql_error());

                           $results2 = $db->numrows($r_subs);

                           if ($results2 > 0) echo '<br>';

                           for ($i2 = 0; $i2 < $results2; $i2++) {

                               $f_subs = $db->fetcharray($r_subs);

                               if ($f_subs['fcounter'] > 0) {

                                   if ($def_rewrite == "YES") echo '<a href="'.$def_mainlocation.'/'.rewrite($f['category']).'/'.rewrite($f_subs['subcategory']).'/'.$f['selector'].'-'.$f_subs['catsubsel'].'-0.html">';
                                   else echo '<a href="'.$def_mainlocation.'/index.php?cat='.$f['selector'].'&subcat='.$f_subs['catsubsel'].'">';

                                   echo '<span class="subcat">'.$f_subs['subcategory'].'</span></a>';

                                        if ($def_show_indexes == "YES") echo ' <span class="count">['.$f_subs['fcounter'].']</span>';

                                                if ($results2 > $i2 + 1) echo ', ';
                               }

                               else {

                                   echo ' <span class="emptycat2">'.$f_subs['subcategory'].'</span>';

                                    if ($results2 > $i2 + 1) echo ', ';
                               }
                            }
                                    if ($results2 > 0) echo '<br>';
                       }
        }
        
        else { echo '<span class="emptycat">'.$f['category'].'</span>'; }

	echo '</div>';

        echo '</td></tr></table><br>';
}
?>
       </td>
      </tr>
     </table>
    </td>
   </tr>
  </table>


<?php
