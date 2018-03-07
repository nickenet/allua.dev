<?php /*

Шаблон вывода последних новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<ul class="nav nav-tabs">
  <li class="active"><a href="#home" data-toggle="tab">Новости каталога</a></li>
  <li class="hidden-xs"><a href="#profile" data-toggle="tab">Новости компаний</a></li>
  <li class="hidden-xs"><a href="#messages" data-toggle="tab">Объявления</a></li>
  <li class="hidden-xs"><a href="#settings" data-toggle="tab">Вакансии</a></li>
  <li class="hidden-xs"><a href="#settings" data-toggle="tab">Тендеры</a></li>
  <li class="hidden-xs"><a href="#settings" data-toggle="tab">Пресс-релизы</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="home"><?php include("./includes/show_news.php"); ?></div>
  <div class="tab-pane hidden-xs" id="profile"><?php if ($def_lastshow_news == "YES") { $last_type=1; include ("./lastinfo.php"); } ?></div>
  <div class="tab-pane hidden-xs" id="messages"><?php if ($def_lastshow_board == "YES") { $last_type=3; include ("./lastinfo.php"); } ?></div>
  <div class="tab-pane hidden-xs" id="settings"><?php if ($def_lastshow_job == "YES") { $last_type=4; include ("./lastinfo.php"); } ?></div>
  <div class="tab-pane hidden-xs" id="settings"><?php if ($def_lastshow_tender == "YES") { $last_type=2; include ("./lastinfo.php"); } ?></div>
  <div class="tab-pane hidden-xs" id="settings"><?php if ($def_lastshow_pressrel == "YES") { $last_type=5; include ("./lastinfo.php"); } ?></div>
</div>


