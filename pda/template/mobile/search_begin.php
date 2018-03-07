<? /*

Шаблон вывода верхей части результатов поиска

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1><? echo $def_search; ?></h1>
  <div style="padding: 3px;">
   <?php echo "$def_company_search <b>( $words )</b>
     &nbsp;&nbsp;[$def_results: <b>$results_amount</b> // [ $sdate1, $sdate3 ]"; ?><br>
  </div>

