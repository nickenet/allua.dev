<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: header.php
-----------------------------------------------------
 Назначение: Header шаблона
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo"$def_title_user"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="icon" href="<? echo $def_mainlocation; ?>/users/template/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<? echo $def_mainlocation; ?>/users/template/images/favicon.ico" type="image/x-icon" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<link href="<? echo $def_mainlocation; ?>/users/template/css/style.css" rel="stylesheet" type="text/css">
<link href="<? echo $def_mainlocation; ?>/users/template/css/bootstrap.css" rel="stylesheet" type="text/css">

<script src="<? echo $def_mainlocation; ?>/users/template/includes/calendar.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/users/template/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/users/template/SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/includes/js/jquery.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/users/template/SpryAssets/bootstrap.min.js" type="text/javascript"></script>
<script src="<? echo $def_mainlocation; ?>/users/template/SpryAssets/application.js" type="text/javascript"></script>

<link href="<? echo $def_mainlocation; ?>/users/template/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<link href="<? echo $def_mainlocation; ?>/users/template/SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">

</head>

<body>

  <div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="brand" href="<? echo $def_mainlocation; ?>" target="_blank">Каталог</a>
        <div class="nav-collapse">
          <ul class="nav">
            <li class="active"><a href="user.php?REQ=authorize">Главная кабинета</a></li>
          </ul>
          <form class="navbar-search pull-left" action="<? echo $def_mainlocation.'/search-1.php'; ?>" method="POST">
            <input type="text" class="search-query span2" name="skey" placeholder="Поиск">
          </form>
          <ul class="nav">
            <li><a href="<? echo $def_mainlocation.'/view.php?id='.$f['selector']; ?>" target="_blank">Моя страница</a></li>
            <li><a href="<? if ($f['domen']=='') echo 'user.php?REQ=authorize&mod=seo'; else echo $def_mainlocation.'/'.$f['domen']; ?>" target="_blank">Социальная страничка</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Страницы <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<? echo $def_mainlocation.'/offers.php?id='.$f[selector].'&type=all'; ?>" target="_blank">Продукция и услуги</a></li>
                <li><a href="<? echo $def_mainlocation.'/gallery.php?id='.$f[selector]; ?>" target="_blank">Галерея изображений</a></li>
		<li><a href="<? echo $def_mainlocation.'/exel.php?id='.$f[selector]; ?>" target="_blank">Прайс-листы</a></li>
		<li><a href="<? echo $def_mainlocation.'/video.php?id='.$f[selector]; ?>" target="_blank">Видеоролики</a></li>
		<li><a href="<? echo $def_mainlocation.'/reviews.php?id='.$f[selector]; ?>" target="_blank">Комментарии</a></li>
                <li class="divider"></li>
                <li><a href="<? echo $def_mainlocation.'/view.php?id='.$f[selector]; ?>" target="_blank">Основная страница</a></li>
                <li><a href="<? echo $def_mainlocation_pda.'/view.php?id='.$f[selector]; ?>" target="_blank">Мобильная страница</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav pull-right">
            <li><a href="<? echo $def_mainlocation.'/index.php?OUT=logout'; ?>">Выход</a></li>
            <li class="divider-vertical"></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Разделы каталога <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<? echo $def_mainlocation.'/compare.php'; ?>" target="_blank">Тарифы</a></li>
                <li><a href="<? echo $def_mainlocation.'/stat.php'; ?>" target="_blank">Статистика</a></li>
                <li><a href="<? echo $def_mainlocation.'/ratingtop.php'; ?>" target="_blank">Рейтинг</a></li>
                <li><a href="<? echo $def_mainlocation_pda; ?>" target="_blank">Мобильная версия</a></li>
                <li class="divider"></li>
                <li><a href="<? echo $def_mainlocation.'/rss.php'; ?>" target="_blank">RSS канал</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" valign="top"><table width="250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td align="center"><table width="245" border="0" cellspacing="0" cellpadding="0" id="klient">
          <tr>
            <td><table width="240" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="40"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/home.gif" width="40" height="39"></td>
                <td width="200" align="left">Пользователь:<br>
                  <span class="id_url"><? echo "$f[login]";  ?></span></td>
              </tr>
              <tr>
                <td colspan="2" align="left">Ваш Id в системе: <span class="id_url"><? echo "$f[selector]";  ?></span><br>
                  URL в каталоге:<br>
                  <input name="url_id" type="text" id="url_id" value="<? echo "$def_mainlocation/view.php?id=$f[selector]";  ?>">
                  Имя страницы:<br>
                  <input name="url_id" type="text" id="url_id" value="<? if ($f[domen]!='') echo "$def_mainlocation/$f[domen]";  ?>">
                  Дата регистрации: <? echo undate($f[date], $def_datetype); ?></td>
                </tr>
              <tr>
                <td colspan="2" align="right" style="padding-top:4px;"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/tarif.gif" width="32" height="32" align="absmiddle">Тариф: <span class="tariff"><? mytarif($f[flag]); ?></span>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="4"></td>
      </tr>
      <tr>
        <td align="center"><table width="245" border="0" cellspacing="0" cellpadding="0" id="uprava">
          <tr>
            <td><table width="240" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td colspan="2" class="zagn">Панель управления</td>
              </tr>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/report__pencil.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=moduser">Изменить общую информацию</a></td>
              </tr>
<?php
if  ($def_reviews_enable=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/balloon.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=reviews">Комментарии</a> <?php if ($f[new_rev]>0) echo "<font size=\"-1\" color=red>($f[new_rev])</font>"; ?></td>
              </tr>
<?php } ?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/crown.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=logo">Логотип организации</a></td>
              </tr>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/compass.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=sxema">Схема проезда</a></td>
              </tr>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/map.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=map">Местоположение на карте</a></td>
              </tr>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/globe.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=filial">Филиалы</a></td>
              </tr>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/application_image.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=banner">Управление баннерами</a></td>
              </tr>
<?php
if  ($def_allow_info=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/briefcase.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=info">Информационный блок</a></td>
              </tr>
<?php
}
if  ($def_allow_images=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/images.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=edgallery">Галерея изображений</a></td>
              </tr>
<?php
}
if  ($def_allow_products=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/market.gif" width="15" height="18"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=edoffers">Продукция и услуги</a></td>
              </tr>
<?php
}
if ($def_allow_exel=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/document_excel.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=edexcel">Прайс-листы</a></td>
              </tr>
<?php
}
if ($def_allow_video=="YES")
{
?>
              <tr>
                <td width="30" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/films.png" width="16" height="16"></td>
                <td align="left" height="23" class="mainmenu"><a href="user.php?REQ=authorize&mod=edvideo">Видеоролики</a></td>
              </tr>
<?php
}

// подключаем разделы для сторонних модулей

require ('template/apx_left.php');

?>
              <tr>
                <td width="30" align="center">&nbsp;</td>
                <td align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="padding:3px;" align="center">
<?

$social = explode(":", $f['social']);

if ($social[0]!='') echo '&nbsp;<a href="http://twitter.com/'.$social[0].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter_big.png" alt="twitter" align="absmiddle" border="0"></a>&nbsp;';
if ($social[1]!='') echo '&nbsp;<a href="http://facebook.com/'.$social[1].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook_big.png" alt="facebook" align="absmiddle" border="0"></a>&nbsp;';
if ($social[2]!='') echo '&nbsp;<a href="http://vk.com/'.$social[2].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte_big.png" alt="vkontakte" align="absmiddle" border="0"></a>&nbsp;';
if ($social[3]!='') echo '&nbsp;<a href="http://odnoklassniki.ru/'.$social[3].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki_big.png" alt="odnoklassniki" align="absmiddle" border="0"></a>&nbsp;';

?>
        </td>
      </tr>
    </table></td>
    <td valign="top" style="padding-left:5px; padding-right:5px; padding-top:4px;">