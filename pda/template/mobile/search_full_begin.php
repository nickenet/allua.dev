<? /*

Шаблон вывода верхей части результатов поиска

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1><? echo $def_search_adv; ?></h1>
  <div style="padding: 3px;">
   <?php echo "[$def_results: <b>$results_amount_search</b> // [ $sdate1, $sdate3 ]"; ?><br>
  </div>

