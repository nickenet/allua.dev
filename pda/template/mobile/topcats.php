<?php /*

Шаблон вывода популярных категорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}


 $top_cat_q=$db->query ("SELECT selector, category FROM $db_category WHERE top > 0 and fcounter > 0 ORDER by top DESC LIMIT $def_show_topcat_number");
 $top_cat_r=$db->numrows($top_cat_q);

 for ($top_cat_f=0; $top_cat_f<$top_cat_r; $top_cat_f++)

 {

 	$top_cat_res=$db->fetcharray ($top_cat_q);

 	echo "&nbsp;&raquo; <a href=\"$def_mainlocation_pda/index.php?category=$top_cat_res[selector]\">$top_cat_res[category]</a><br />";

 }

?>