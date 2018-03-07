<?php /*

Шаблон вывода поисковой формы, по первой букве, новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<div style="margin-top: -20px;">

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <div class="container">
            <div class="carousel-caption">
              <h1>Бесплатная регистрация</h1>
              <p>Уже сегодня Вы можете получить первых клиентов с нашего каталога!</p>
              <p><a class="btn btn-lg btn-primary" href="/reg.php" role="button">Добавить компанию</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Тарифные планы</h1>
              <p>Максимальную отдачу Вы можете ощутить при переходе на платный тариф в нашем каталоге!</p>
              <p><a class="btn btn-lg btn-primary" href="/compare.php" role="button">Тарифы</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
              <h1>Мы сделаем все сами</h1>
              <p>У Вас нет времени? Сообщите нам и мы добавим Вашу компанию самостоятельно и бесплатно!</p>
              <p><a class="btn btn-lg btn-primary" href="./contact.html" role="button">Написать нам</a></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->

</div>

<div class="container marketing">
<?php

	if ($def_allow_index == "YES") include ("./searchform.inc.php"); // Форма поиска

        if ($def_news_module == "YES") include ( "./template/$def_template/show_news.php" ); // Новости

?>

        <div class="row featurette">
        <div class="col-md-9">
<hr>
        <?php include ("./includes/alpha_view.php"); // Поиск по первой букве ?>
            