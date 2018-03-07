<?php

if( ! defined( 'ISB' )) {
  die( "Hacking attempt!" );
}

include ("./includes/common_header.php"); ?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <title><?php IF ($incomingline == $def_catalogue ) {echo $def_title;} else { IF (!$incomingline_firm) {title ($incomingline);} else { echo $incomingline_firm . "-" . $def_title; }} ?></title>
    <meta charset="<?php echo"$def_charset"; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $descriptions_meta; ?>">
    <meta name="keywords" content="<?php echo $keywords_meta; ?>">
    <meta name="author" content="vkaragande.info">
    <meta name="copyright" CONTENT="Copyright, vkaragande.info. All rights reserved">
    <meta name="revisit-after" content="7 days">
    <meta name="author" content="vkaragande.info">
    <?php echo $meta_index; ?>
    <?php echo $meta_system; ?>
    
    <link rel="icon" href="<?php echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo "$def_mainlocation/template/$def_template/images/"; ?>favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title=<?php echo "\"$def_title\""; ?> href=<?php echo "\"$def_mainlocation/rss.xml\""; ?> />

    <link rel="stylesheet" href="<?php echo "$def_mainlocation/template/$def_template/"; ?>bcss/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo "$def_mainlocation/template/$def_template/"; ?>bcss/css/carousel.css">
    <link rel="stylesheet" href="<?php echo "$def_mainlocation/template/$def_template/"; ?>css.css">

    <?php include ("./includes/js.php"); ?>

   <script src="<?php echo "$def_mainlocation/template/$def_template/"; ?>bcss/js/bootstrap.min.js"></script>
   <script src="<?php echo "$def_mainlocation/template/$def_template/"; ?>bcss/js/docs.js"></script>

  </head>

<!-- NAVBAR
================================================== -->
  <body>

   <!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
                <li><a href="<?php echo "$def_mainlocation"; ?>/index.php">Главная</a></li>
                <li><a href="<?php echo "$def_mainlocation"; ?>/viewstatic.php?vs=catalog">О Каталоге</a></li>
                <li><a href="<?php echo "$def_mainlocation"; ?>/viewstatic.php?vs=info">Правила</a></li>
                <li><a href="<?php echo "$def_mainlocation"; ?>/compare.php">Тарифные планы</a></li>
                <li><a href="<?php echo "$def_mainlocation"; ?>/contact.php">Контакты</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Разделы портала <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <?php include ( "./menu.php" ); ?>
                  </ul>
                </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="<?php echo "$def_mainlocation"; ?>/reg.php">Добавить организацию</a></li>
                <li><a href="<?php echo "$def_mainlocation"; ?>/user.php">Вход</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

   <?php if ($incomingline != $def_catalogue) { 
echo '<div class="hidden-xs"><div style="margin-top: -20px; margin-bottom: 3px;"><div id="header_top"><div class="gorod_left"><div class="gorod_right"><div class="logo_main"><div id="id_content_logo" class="txt_logo">Социальная сеть организаций, товаров и услуг. Виртуальные офисы фирм. Социальные страницы компаний.</div></div></div></div></div></div></div>';
echo '<div class="container marketing">
     <div class="row featurette">
        <div class="col-md-9">'; // Не главная страница
   include ( "./template/$def_template/top_line.php" ); }
   ?>
   
 <?php

 // TOP BANNER CODE

 if (( $def_banner_allowed == "YES" ) and ($show_banner != "NO"))

 {

 ?>

   <div style="text-align: center;" class="hidden-xs">

   <?php 

   $banner_type="top";
   include ( "./banner.php" );
   
   

   ?>
   
   </div>
    
    <div style="text-align: center;"><?php $reklama="bottom_banner"; include ( "./reklama.php" ); ?></div><br>

<?php

 }

?>   

     






     <!-- HEADER END -->
