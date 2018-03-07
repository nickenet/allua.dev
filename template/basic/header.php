<?php

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

include ("./includes/common_header.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<head>

<title>
<? IF ($incomingline == $def_catalogue ) {echo $def_title;} else
{
IF (!$incomingline_firm) {title ($incomingline);} else
{ echo $incomingline_firm . "-" . $def_title; }
}
?>
</title>
 <META http-equiv="Content-Type" content="text/html; charset=<? echo"$def_charset"; ?>">
 <META NAME="Description" CONTENT="<? echo "$descriptions_meta"; ?>" >
 <META NAME="Keywords" CONTENT="<? echo "$keywords_meta"; ?>">
 <META name="author" content="vkaragande.info">
 <META name="copyright" CONTENT="Copyright, vkaragande.info. All rights reserved">
 <META name="revisit-after" content="7 days">
 <? echo $meta_index; ?>
 <? echo $meta_system; ?>

<link rel="icon" href="<? echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<? echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title=<? echo "\"$def_title\""; ?> href=<? echo "\"$def_mainlocation/rss.xml\""; ?> />

<? echo "$def_style"; ?>

<? include ("./includes/js.php"); ?>

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="2" bgcolor="#223388"></td>	
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="22" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_menu_top.gif" bgcolor="#FF6600" class="mainmenu" style="padding-left:15px;"><a href="<? echo "$def_mainlocation"; ?>/">Главная</a> | <a href="<? echo "$def_mainlocation"; ?>/viewstatic.php?vs=catalog">О каталоге</a> | <a href="<? echo "$def_mainlocation"; ?>/viewstatic.php?vs=info">Правила</a> | <a href="<? echo "$def_mainlocation"; ?>/compare.php">Тарифные планы</a> | <a href="<? echo "$def_mainlocation"; ?>/ratingtop.php">Рейтинг компаний. ТОП20</a> | <a href="<? echo "$def_mainlocation"; ?>/stat.php">Статистика каталога</a> | <a href="<? echo "$def_mainlocation"; ?>/contact.php">Контакты</a> | <a href="<? echo "$def_mainlocation"; ?>/rss.php">RSS</a></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="80" valign="top" bgcolor="#223388"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="80" class="logo_in"><div style="padding-left:120px;">Организации регион<br /><span class="top_menu">&nbsp;&nbsp;&nbsp;Бизнес-справочник</span></div></td>
          </tr>
        </table></td>
        <td width="48%" align="right" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><table width="270" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" height="35" align="left" valign="top" bgcolor="#FFFF00" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_login.gif"><div style="padding-left:35px; padding-top:8px;"><a href="<? echo "$def_mainlocation"; ?>/user.php">Вход для клиентов</a></div> </td>
                <td width="120" height="35" align="left" valign="top" bgcolor="#448CCB" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_reg.gif"><div style="padding-left:33px; padding-top:8px;"><a href="<? echo"$def_mainlocation"; ?>/reg.php">Регистрация</a></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" style="padding-left:15px;"><table width="150" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="18"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>pda.gif" width="18" height="18"></td>
                <td height="18" class="top_menu"><a href="<? echo "$def_mainlocation_pda"; ?>" >Мобильная версия</a></td>
              </tr>
              <tr>
                <td width="18"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>r_search.gif" width="18" height="18"></td>
                <td height="18" class="top_menu"><a href="<? echo "$def_mainlocation"; ?>/search.php" >Расширенный поиск</a></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="20" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_speedbar.gif" bgcolor="#757575"><? include ("./includes/top_line.php"); ?></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#223388"></td>
  </tr>
  <tr>
    <td height="4" bgcolor="#FFFFFF"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="220" valign="top">

    <? include ( "./menu.php" ); ?>

    <div align=center><? if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div><br><br>

    <? if ($def_top_categories_show == "YES") include ("./topcats.php"); ?>

    <? if ($def_kurs == "YES") include ("./kurs.php"); ?>

    <? if ($def_last10show == "YES") include ("./last.php"); ?>

   <? if ($def_rssinform == "YES") include ("./rssinfo.php"); ?>

    </td>
    <td align="center" valign="top" style="padding-left:5px; padding-right:5px;">
 <?php

 // TOP BANNER CODE

 if (( $def_banner_allowed == "YES" ) and ($show_banner != "NO"))

 {

 ?>

 <table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
   <td valign="middle" align="center" width="100%">

   <?php 

   $banner_type="top";
   include ( "./banner.php" ); ?><br>

   </td>
  </tr>
 </table>

<?php

 }

?>
     <!-- HEADER END -->
