<?php /*

Шаблон вывода нижней части быстрого поиска

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<div align="left">
    <b>Похожие запросы:</b><br>
    <?php echo $requests->simular($sstring); ?>

<?php 
            if ($result_plus=="YES") {
                echo '<br><br>Запрос (<b>'.$words.'</b>) также найден:';

                if ($results_amount_offers>0) echo '<br> &#187 <a href="search-2.php?search='.$goodencoded.'">'.$def_search_offerss.'</a> ('.$results_amount_offers.')';
                if ($results_amount_img>0) echo '<br> &#187 <a href="search-4.php?search='.$goodencoded.'">'.$def_search_img.'</a> ('.$results_amount_img.')';
                if ($results_amount_xls>0) echo '<br> &#187 <a href="search-6.php?skey='.$goodencoded.'">'.$def_search_xls.'</a> ('.$results_amount_xls.')';
                if ($results_amount_pub>0) echo '<br> &#187 <a href="search-5.php?skey='.$goodencoded.'">'.$def_search_pub.'</a> ('.$results_amount_pub.')';

                echo '<br><br>';
            }            
?>            

<br><b>Последние 10 запросов:</b><br>
<?php echo $requests->get(10); ?>
</div>