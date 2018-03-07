<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>*metatitle*</title>
<meta name="description" content="*metadescription*">
<meta name="keywords" content="*metakeywords*">

<link rel="icon" href="*dir_to_images_theme*/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="*dir_to_images_theme*/favicon.ico" type="image/x-icon">

<link href="*dir_to_theme*/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="*dir_to_theme*/css/style.css" rel="stylesheet" type="text/css">
<link href="*dir_to_theme*/css/apx.css" rel="stylesheet" type="text/css">
<script src="*dir_to_main*/includes/js/jquery.js"></script>
<script src="*dir_to_theme*/js/bootstrap.min.js"></script>
<script src="*dir_to_theme*/js/application.js"></script>
<script src="*dir_to_theme*/js/apx.js"></script>

<style type="text/css">

body {
  margin: 0;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
  line-height: 18px;
  color: #333333;
  background-color: #ffffff;
  background-image: url(*css_img_bg*);
  background-attachment: fixed;
}

.header {
	text-decoration: none;
	background-image: url(*css_img_header*);
	background-repeat: no-repeat;
	margin-right: auto;
	margin-left: auto;
	height: *css_height_header*px;
	width: 940px;
}

.header_position {
	padding: *css_header_top*px *css_header_left*px;
}

</style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>


  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="brand" href="*dir_to_main*" target="_blank">Каталог</a>
        <div class="nav-collapse">
          <ul class="nav">
            <li class="active"><a href="*dir_to_main*/view.php?id=*id_company*">*company*</a></li>
          </ul>
          <form class="navbar-search pull-left" action="*dir_to_main*/search-1.php" method="POST">
            <input type="text" class="search-query span2" name="skey" placeholder="Поиск">
          </form>
          <ul class="nav pull-right">
            <li><a href="*dir_to_main*/users/user.php?REQ=authorize">Кабинет</a></li>
            <li class="divider-vertical"></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Разделы каталога <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="*dir_to_main*/reg.php" target="_blank">Регистрация в каталоге</a></li>
                <li><a href="*dir_to_main*/compare.php" target="_blank">Тарифы</a></li>
                <li><a href="*dir_to_main*/stat.php" target="_blank">Статистика</a></li>
                <li><a href="*dir_to_main*/ratingtop.php" target="_blank">Рейтинг</a></li>
                <li class="divider"></li>
                <li><a href="*dir_to_main*/rss.php" target="_blank">RSS канал</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>


<header>
<div class="header_top"></div><div class="header"><div class="header_position"><h1 style="color:*css_h1_color*">*header_title*</h1></div></div>
</header>
<div class="container main_con">

    <div class="container-fluid">
    	<div class="row-fluid">
    		<div class="span4">

			    <ul class="nav nav-pills nav-stacked" style="padding-top:5px;">
			    	<li class="active"><a href="*link_to_social*">*link_to_main*</a></li>
				<li>*link_to_news*</li>
				<li>*link_to_tender*</li>
				<li>*link_to_board*</li>
				<li>*link_to_job*</li>
				<li>*link_to_pressrel*</li>
				<li>*link_to_offers*</li>
				<li>*link_to_excel*</li>
				<li>*link_to_images*</li>
				<li>*link_to_video*</li>
				<li>*friend*</li>
				<li>*addreview*</li>
				<li>*mail*</li>
			    </ul>
		<hr />
                    <div class="alert alert-info">

                            <div itemscope itemtype="http://schema.org/Organization">
                                    <span itemprop="name"><b>*company*</b></span>  *case*<br />
                                    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                            <span itemprop="streetAddress">*address*</span><br />
                                            <span itemprop="addressLocality">*city*</span>
                                    </div>
                                            <span itemprop="telephone">*phone*</span>
                            </div>

                                    <span style="font-size: 9px;">*map*</span>
                                    *sxema* &nbsp;&nbsp;<a style="font-size: 11px;" data-toggle="modal" href="#myModal">&laquo; Все контакты &raquo;</a>
                    </div>
                    <hr />

                        <div style="text-align:center;"><div class="btn btn-mini disabled">*rev_good* *rev_bad* *viewreviews*</div>
                        <div style="padding:5px">*rating*</div>*rate*</div>

                        <hr />
                        <div class="alert alert-success"><div style="text-align:right;"><b>Последние отзывы</b></div>*reviews*</div>

                        *view_keywords*

                        <div class="alert alert-success">*cats*</div>

                        <div align="center">*qr*</div>

			<div align="center">*Yandex_map_wym250_hym200*<br>*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*<br></div>

			<div align="right" style="font-size: 11px;">
				Просмотров всего: *hits*<br />
				Просмотров за месяц: *hits_m*<br />
				Просмотров за сегодня: *hits_d*<br />
			</div>

    		</div>

<!-- Контент -->
    		<div class="span8">

			<div style="text-align: right; padding: 3px;">*twitter* *facebook* *vkontakte* *odnoklassniki* <a href="*dir_to_main*/view.php?id=*id_company*&type=print"><img src="*dir_to_images_theme*/print.png" border="0"></a> *translate*</div>
                        *publications*
                        <div style="padding: 5px; 3px;">*description*</div>
                            <hr />

                        <ul class="thumbnails">
                            *view_offers*
                        </ul>
                            <hr />

                        <ul class="thumbnails">
                            *view_images*
                        </ul>


    		</div>
<!-- / Контент -->


    	</div>
    </div>

<footer class="footer">

    <div class="row">
    <div class="span8">
        <p class="tooltip-demo wellt"><a  title="Создать свою социальную страницу &raquo;" rel="tooltip" href="*dir_to_main*/reg.php">*title* &copy; 2018</a></p>
        <p>&copy; 2016 *company*</p>
	<p><noindex><a rel="nofollow" href="*link_to_complaint*">*text_to_complaint*</a></noindex></p>
    </div>
    <div class="span4"><p>Счетчики</p></div>
    </div>

</footer>

</div>



          <div id="myModal" class="modal hide fade">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h3>*company*</h3>
            </div>
            <div class="modal-body">
<p><b>Страна</b> - *country*</p>
<p><b>Область</b> - *state*</p>
<p><b>Город</b> - *city*</p>
<p><b>Адрес</b> - *address*</p>
<hr />
<p><b>Контактное лицо</b> - *contact*</p>
<p><b>Телефон</b> - *phone*</p>
<p><b>Факс</b> - *fax*</p>
<p><b>Мобильный</b> - *mobile*</p>
<p><b>ICQ</b> - *icq*</p>
<p>*filiallist*</p>
<p class="btn">*mail*</p>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal" >Закрыть</a>
            </div>
          </div>

</body>
</html>