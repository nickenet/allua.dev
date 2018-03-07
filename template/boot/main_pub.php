<?php 

/*

Шаблон вывода последних публикаций

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

       <hr>

<div class="panel panel-primary">
  <div class="panel-heading">Новые компании</div>
  <div class="panel-body">
    <div class="block_firm"><?php include ("./last.php"); ?></div>
  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">Обновленные компании</div>
  <div class="panel-body">
    <div class="block_firm"><?php include("./lastmod.php"); ?></div>
  </div>
</div>

<div class="panel panel-success">
  <div class="panel-heading">Рейтинг компаний</div>
  <div class="panel-body">
    <div class="block_firm"><?php include("./top.php"); ?></div>
  </div>
</div>