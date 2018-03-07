<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: upgrade.php
-----------------------------------------------------
 Назначение: Проверка обновлений системы
=====================================================
*/

session_start();

require_once './defaults.php';

$keys_version=array("4.7.1", "4.7.2", "4.7.3", "4.7.4", "4.7.5", "4.7.6", "4.7.7", "4.7.8", "4.7.9", "4.7.10", "4.7.11", "4.7.12", "4.7.13", "4.7.14", "4.7.15", "4.7.16", "4.7.17", "4.7.18", "4.7.19", "4.7.20", "4.7.21", "4.7.22", "4.7.23");
$error_version = 0;
$new_mod = 0;

$help_section = (string)$upgrade_help;

$title_cp = 'Проверка обновлений - ';

if (isset($_GET['link'])) {

    $link_to_new_mod=htmlspecialchars($_GET['link'],ENT_QUOTES,$def_charset);    
    @$str = file_get_contents ($link_to_new_mod);
    @preg_match("#<!-- begin_news_isb -->(.*?)<!-- end_news_isb -->#is", $str, $m);
    @preg_match("#<span class=\"ntitle\">(.*?)</span>#is", $str, $f);
    $speedbar = ' | <a href="upgrade.php">Проверка обновлений системы</a> | <a href="upgrade.php?link='.$link_to_new_mod.'">Информация по модификации:'.$f[1].'</a>';

} else $speedbar = ' | <a href="upgrade.php">Проверка обновлений системы</a>';

check_login_cp('0_0','upgrade.php');

require_once 'template/header.php';

table_item_top ('Проверка обновлений системы','upgrade.png');

$upgrade = file('http://vkaragande.info/upgrade/upgrade.txt');

require 'inc/upgrade_system.php';
require 'inc/upgrade_table.php';
if (isset($_GET['key'])) require 'inc/upgrade_baza.php';

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
        text-align: center;
	border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
	height: 25px;
	padding-top: 2px;
	padding-left: 5px;
	text-align: center;
	border: 1px solid #A6B2D5;
        }
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>

<?

if (isset($_GET['link'])) {
    
    @$text = preg_replace("'<div class=\"quote\">.*?</div>'", '<a target="_blank" title="Перейти" href="'.$link_to_new_mod.'">модификацию</a>', $m[1]);

?>

<table width="1000" class="main_list" align="center">
  <tr>
    <th width="80"><div align="left">Название модификации: <? echo $f[1]; ?></div></th>
  </tr>
  <tr>
    <td><div align="left"><? echo $text; ?></div></td>
  </tr>
</table>

<?

} else {

?>

<table width="800" class="main_list" align="center">
  <tr>
    <th width="80">Код</th>
    <th width="70">Дата</th>
    <th width="410">Название обновления</th>
    <th width="120">Диагностика<br />переменных</th>
    <th width="120">Диагностика<br />таблиц базы</th>
  </tr>

<?

foreach ($upgrade as $line_num => $line) {

    $view_mod =  explode('|', $line);

?>

  <tr class="selecttr">
    <td><? echo $view_mod[0]; ?></td>
    <td><? echo $view_mod[1]; ?></td>
<? if (in_array($view_mod[0], $keys_version))   { ?>
    <td><div align="left" class="slink"><a target="_blank" title="Перейти" href="<? echo $view_mod[3]; ?>"><? echo $view_mod[2]; ?></a></div></td>
    <td><? upgrade_system($view_mod[0]); ?></td>
    <td><? upgrade_table($view_mod[0]); ?></td>
<?  } else { $new_mod++; ?>
    <td><div align="left" style="color:#FF0000;"><? echo $view_mod[2]; ?><img src="images/new.png" alt="Новая модификация" title="Новая модификация" width="24" height="24" align="absmiddle" /></div></td>
    <td colspan="2"><div align="center" class="slink"><a title="Перейти" href="upgrade.php?link=<? echo $view_mod[3]; ?>">Ознакомиться</a> | <a target="_blank" title="Перейти" href="<? echo $view_mod[3]; ?>">Перейти и загрузить</a> <img src="images/download.png" alt="Загрузить" title="Загрузить" width="24" height="24" align="absmiddle" /></div></td>
<? } ?>
  </tr>

<?
}

?>

</table>

<br />

<?php

if ($error_version==1) $error_text='ошибка';
if ($error_version>=2 and $error_version<=4) $error_text='ошибки';
if ($error_version>4) $error_text='ошибок';

if ($error_version>0) echo '<div style="padding-left: 30px;">Обнаружено: <b>'.$error_version.'</b> '.$error_text.' в обновлениях. <span style="color:#FF0000;">Рекомендуем установить недостающие обновления!</span></div>';
else echo '<div style="padding-left: 30px;">У Вас установлена версия <b>'.end($keys_version).'</b></div>';

if ($new_mod>0) echo '<br /><div style="padding-left: 30px;">Найдено новых обновлений: <b>'.$new_mod.'</b>. <span style="color:#FF0000;">Рекомендуем установить недостающие обновления!</span></div>';

if ($new_mod==0 and $error_version==0) echo '<br /><div style="padding-left: 30px; color:#006600;">Актуальная версия скрипта.</div>';

}

require_once 'template/footer.php';

?>