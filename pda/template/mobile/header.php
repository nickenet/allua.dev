<? include ("./includes/common_header.php"); ?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title><? IF ($incomingline == $def_catalogue ) echo $def_title; else { if (!$incomingline_firm) title ($incomingline); else echo $incomingline_firm; }?></title>
<link href="<? echo "$def_mainlocation_pda/template/$def_template"; ?>/css/style.css" rel="stylesheet" type="text/css">
<link href="<? echo "$def_mainlocation_pda/template/$def_template"; ?>/css/media-queries.css" rel="stylesheet" type="text/css">
<link rel="icon" href="<? echo "$def_mainlocation_pda/template/$def_template/images/"; ?>favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="<? echo "$def_mainlocation_pda/template/$def_template/images/"; ?>favicon.png" type="image/x-icon" />
<script src="<? echo "$def_mainlocation/includes/js/"; ?>jquery.js"></script>
<script src="<? echo "$def_mainlocation/includes/js/"; ?>filter.js"></script>
<script src="<? echo "$def_mainlocation/includes/js/"; ?>dropdown.js"></script>

<? echo qautocomplete_echo(); ?>

<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body>

<div id="pagewrap">

	<header id="header">

		<hgroup>
			<h1 id="site-logo"><a href="<? echo $def_mainlocation_pda; ?>">Mobile</a></h1>
			<h2 id="site-description">Легкая версия</h2>
		</hgroup>

		<nav>
			<ul id="main-nav" class="clearfix">
				<li><a href="<? echo $def_mainlocation_pda; ?>">Главная</a></li>
				<li><a href="<? echo $def_mainlocation_pda; ?>/index.php?lastnews">Новости</a></li>
				<li><a href="<? echo $def_mainlocation_pda; ?>/index.php?lenta">Лента</a> </li>
			</ul>
			<!-- /#main-nav -->
		</nav>

		<form id="searchform" name="search" action="search-1.php" method="post">
			<input type="search" id="autocomplete" name="skey" value="<? echo $sstring; ?>" placeholder="Поиск">
		</form>

	</header>

	<div id="content">
            <? include ("./template/$def_template/alert.php"); ?>
