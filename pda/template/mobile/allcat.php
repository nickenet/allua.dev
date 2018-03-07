<? /*

Шаблон вывода категорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1 class="post-title">Все категории</h1>

<div class="category">

<?
	 $r = $db->query ( "SELECT fcounter, selector, category FROM $db_category WHERE fcounter > 0 ORDER BY category " );
	 $results = $db->numrows ( $r );
	 $res = round ( $results);
	 for ( $i=0;$i<=$res;$i++ ) {

 		$f = $db->fetcharray ( $r );
	 	if ( $f['fcounter'] > 0 ) echo '<p>&nbsp;&raquo; <a href="index.php?category='.$f['selector'].'">'.$f[category].'</a></p>';
	}
?>

</div>

