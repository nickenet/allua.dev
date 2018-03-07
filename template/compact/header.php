<? include ("./includes/common_header.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
 
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

<? include ("./includes/js.php"); ?>

	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/core.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/widget.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/tabs.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/dialog.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/accordion.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/position.js"></script>
	<script src="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/slides.js"></script>

	<link rel="stylesheet" href="<? echo "$def_mainlocation/template/$def_template/"; ?>ui/ui.css">

	<? echo "$def_style"; ?>

	<script>
	$(function() {
		$( "#tabs" ).tabs();
		$( "#tabs1" ).tabs();
		$( "#tabs2" ).tabs();
		$( "#tabs3" ).tabs();

		$( "#dialog" ).dialog({
			autoOpen: false,
			resizable: false,
			modal: true,
			show: "explode",
			hide: "explode"
		});

		$( "#opener" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			return false;
		});
		$('#slides').slides({
			effect: 'fade',
			play: 5000,
			pause: 2500,
			generatePagination: false,
			preload: true,
			hoverPause: true
		});

	});
	</script>

</head>

<body>

<div class="MainBigContainer">
<div class="MainContainer">
<table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="350"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>logo.png" alt="Логотип" width="350" height="120"></td>
        <td width="300" align="center"><span class="header_logo_txt">I-Soft Bizness</span><br>
          <span class="header_text">каталог организаций и фрим</span></td>
        <td width="195"><a href="<? echo $def_mainlocation; ?>/reg.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>reg.png" alt="Регистрация в каталоге" width="195" height="35" border="0"></a><br>
          <a <? if (isset($_SESSION['login'])) echo 'href="'.$def_mainlocation.'/users/user.php?REQ=authorize"'; else echo 'href="#"  id="opener"'; ?>><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>users.png" alt="Вход в личный кабинет" width="195" height="65" border="0"></a></td>
        <td align="center" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>bg_right.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" align="right"><a href="<? echo "$def_mainlocation_pda"; ?>" ><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>pda.png" alt="Мобильная версия" width="60" height="60" border="0"></a></td>
            <td align="left"><a href="<? echo $def_mainlocation; ?>/rss.php"><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>rss.png" alt="RSS подписка" width="60" height="60" border="0"></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="<? echo "$def_mainlocation/template/$def_template/images/"; ?>top_line_01.png" width="1024" height="13"></td>
  </tr>
  <tr>
    <td height="43" background="<? echo "$def_mainlocation/template/$def_template/images/"; ?>menu_bg_all.gif" bgcolor="#FF6600">
    <div id="menu">
	<ul>
		<li><a href="<? echo $def_mainlocation; ?>/index.php">Главная</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/viewstatic.php?vs=catalog">О каталоге</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/viewstatic.php?vs=info">Правила</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/search.php">Поиск</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/compare.php">Тарифные планы</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/ratingtop.php">Рейтинг компаний. ТОП20</a></li>
		<li><a href="<? echo $def_mainlocation; ?>/stat.php">Статистика</a></li>	
        	<li><a href="<? echo $def_mainlocation; ?>/contact.php">Контакты</a></li>							
	</ul>
    </div>
    </td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF" class="speedbar"><? include ("./includes/top_line.php"); ?></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#CFCFCF"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" style="padding: 5px;">

<?

 // TOP BANNER CODE

 if (( $def_banner_allowed == "YES" ) and ($show_banner != "NO")) { 

?>

 <table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
   <td valign="middle" align="center" width="100%">
   <?php $banner_type="top"; include ( "./banner.php" ); ?><br>
   </td>
  </tr>
 </table>

<? } ?>

     <!-- HEADER END -->