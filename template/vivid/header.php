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
 <? echo $meta_system; ?>
 <? echo $meta_index; ?>

<link rel="icon" href="<? echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<? echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title=<? echo "\"$def_title\""; ?> href=<? echo "\"$def_mainlocation/rss.xml\""; ?> />

 <? echo "$def_style"; ?>

 <? include ("./includes/js.php"); ?>

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="2" colspan="2"></td>
            </tr>
          <tr>
            <td width="190" height="30" align="center" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>fon_izbr.gif">
            <SCRIPT LANGUAGE="javascript">

now = new Date();

	var pad;

	if(now.getMinutes() < 10) {pad = "0"} else pad = "";

	 var day = now.getDay();
	 var dayname;

	 if (day==0)dayname="Воскресение";
	 if (day==1)dayname="Понедельник";
	 if (day==2)dayname="Вторник";
	 if (day==3)dayname="Среда";
	 if (day==4)dayname="Четверг";
	 if (day==5)dayname="Пятница";
	 if (day==6)dayname="Суббота";

	 var monthNames = new Array(".01.",".02.",".03.",".04.",".05.",".06.",".07.",".08.",".09.",".10.",".11.",".12.");
	 var month = now.getMonth();
	 var monthName = monthNames[month];
	 var year = now.getYear();

	 if ( year < 1000 ) year += 1900;
	 var datestring = '<strong>' + dayname + '</strong>&nbsp;&nbsp; <strong><font color="#db0101">' + now.getDate() + '' + monthName + '' + year + '</font></strong>';
	 document.write('<NOBR>&nbsp;' + datestring + '</NOBR>');

</script>            </td>
            <td align="right" class="mainmenu" ><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>reg.gif" alt="Регистрация в каталоге" width="31" height="31" align="absmiddle"><a href="<? echo "$def_mainlocation"; ?>/reg.php" title="Регистрация в каталоге организаций. Вы сможете добавить свою компанию бесплатно.">Добавить организацию</a><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>user.gif" alt="Доступ в личный кабинет" width="31" height="31" align="absmiddle"><a href="<? echo "$def_mainlocation"; ?>/user.php" title="Вход в личный кабинет по управлению аккаунтом"><font color="#009900">Вход для клиентов</font></a><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>pravila.gif" alt="Правила каталога" width="31" height="31" align="absmiddle"><a href="<? echo "$def_mainlocation"; ?>/viewstatic.php?vs=info" title="Правила регистрации в каталоге."><font color="#0066FF">Правила</font></a></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#1F50A8"></td>
      </tr>
      <tr>
        <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="400" height="80"><a href="<? echo "$def_mainlocation"; ?>/index.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>logo.gif" alt="Скрипт каталога организаций I-Soft Bizness" width="400" height="120" border="0"></a></td>
            <td>&nbsp;</td>
            <td width="180"><table width="180" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><a href="<? echo "$def_mainlocation"; ?>/rss.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>rss.gif" alt="Rss" width="48" height="48" border="0"></a><br>
                  <a href="<? echo "$def_mainlocation"; ?>/rss.php">Rss</a></td>
                <td align="center"><a href="<? echo "$def_mainlocation"; ?>/search.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>search.gif" alt="Расширенный поиск" width="48" height="48" border="0"></a><br>
                  <a href="<? echo "$def_mainlocation"; ?>/search.php">Поиск</a></td>
                <td><a href="<? echo "$def_mainlocation"; ?>/contact.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>email.gif" alt="Обратная связь" width="48" height="48" border="0"></a><br>
                  <a href="<? echo "$def_mainlocation"; ?>/contact.php">Контакты</a></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#1F50A8"></td>
      </tr>
      <tr>
        <td height="20" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>top_line_bg.gif"><? include ("./includes/top_line.php"); ?></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#1F50A8"></td>
      </tr>
      <tr>
        <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="220" align="left" valign="top"><table width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="215" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>arrow.gif" alt="Вернуться на главную" width="24" height="24" align="absmiddle"><a href="<? echo "$def_mainlocation"; ?>/index.php">Главная страница</a></td>
                    <td width="24" onClick="javascript:this.style.behavior='url(#default#homepage)';&#13;&#10; this.setHomePage('http://vkaragande.info/')" style="CURSOR: hand" title="сделать домашней"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>home.gif" alt="Сделать домашней" width="24" height="24"></td>
                    <td width="24" onClick="javascript:window.external.AddFavorite('http://vkaragande.info/','Скрипт каталога организаций')" style="CURSOR: hand" title="добавить в избранное"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>goizbr.gif" alt="Добавить в избранное" width="24" height="24"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>
		<? include ( "./menu.php" ); ?>
		</td>
              </tr>
              <tr>
                <td>
		<table width="220" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110" align="center"><a href="<? echo "$def_mainlocation"; ?>/compare.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>memberships.gif" alt="Тарифные планы каталога" width="48" height="48" border="0"></a><br>
                      <a href="<? echo "$def_mainlocation"; ?>/compare.php">Тарифные планы</a></td>
                    <td align="center"><a href="<? echo "$def_mainlocation"; ?>/ratingtop.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>reiting.gif" alt="Рейтинг фирм. Топ20" width="48" height="48" border="0"></a><br>
                      <a href="<? echo "$def_mainlocation"; ?>/ratingtop.php">Рейтинг фирм</a></td>
                  </tr>
                  <tr>
                    <td align="center"><a href="<? echo "$def_mainlocation"; ?>/stat.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>stat.gif" alt="Статистика каталога" width="48" height="48" border="0"></a><br>
                      <a href="<? echo "$def_mainlocation"; ?>/stat.php">Статистика</a></td>
                    <td align="center"><a href="<? echo "$def_mainlocation_pda"; ?>"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>mobilev.gif" alt="Версия для мобильных устройств" width="48" height="48" border="0"></a><br>
                      <a href="<? echo "$def_mainlocation_pda"; ?>">Смарт-версия</a></td>
                  </tr>
                </table>
	      </td>
              </tr>
              <tr>
                <td>
		<div align=center><? if ( $def_banner2_allowed == "YES" ) include ("./banner.php"); ?></div><br><br>

                <? if ($def_top_categories_show == "YES") include ("./topcats.php"); ?>

                <? if ($def_kurs == "YES") include ("./kurs.php"); ?>

                <? if ($def_last10show == "YES") include ("./last.php"); ?>

                <? if ($def_rssinform == "YES") include ("./rssinfo.php"); ?>
		</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td width="560" align="center" valign="top" style="padding-left:5px; padding-right:5px;">
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