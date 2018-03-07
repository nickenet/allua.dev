<? /*

Шаблон - страница контактов (contact.php)

*/ ?>

<h1>Написать нам</h1>

<div id="send_div">
<div id="send_req">
    <div class="form-horizontal" role="form">

<div class="form-group has-default">
    Службы:
      <select name="admin" id="admin" style="padding: 5px; font-size: 12px;" class="form-control">
	      <option value="1" selected>Администратор</option>
	      <option value="2">Отдел размещения рекламы</option>
  	      <option value="3">Отдел по работе с клиентами</option>
      </select>
</div>
        <div style="text-align:center">

                <div id="adm" class="normal">Вопросы по технической части каталога</div>
		<div id="finan" class="normal">Вопросы по размещению рекламы в каталоге</div>
		<div id="reklama" class="normal">Финансовые вопросы. Договора.</div>

        </div>



<div class="form-group has-default">
    Ваше имя:
    <input type="text" id="name" name="name"  maxlength="50" size="35" class="form-control">
</div>

<div class="form-group has-default">
    Телефон:
    <input type="text" id="tel" name="tel" maxlength="50" size="35" class="form-control">
</div>

<div class="form-group has-warning">
    E-mail:
    <input type="text" id="mail" name="mail" maxlength="50" size="35" class="form-control">
</div>

<div class="form-group has-warning">
    Ваше сообщение:
    <textarea name="text" cols="60" rows="10" id="text" class="form-control"></textarea>
</div>

<div class="form-group has-warning">
    Код безопасности:
    *security*&nbsp;<input type="text" id="security" name="security" maxlength="15" class="form-control">
</div>

<div class="form-group has-default">
    <input type="submit" id="send_form" name="inbut" value="Отправить" class="btn btn-primary">
</div>

    </div>

</div>
</div>
<div id="ok_send"></div>

<div align="left">
    <h2>Наши контакты:</h2>
<div itemscope itemtype="http://schema.org/Organization">
  <span itemprop="name"><b>Каталог организаций и фирм</b></span>
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    Адрес:
    <span itemprop="streetAddress">ул. Ержанова, 15</span><br>
    <span itemprop="postalCode"> 1000009</span><br>
    <span itemprop="addressLocality">Караганда,</span>
  </div><br>
  Телефон: <span itemprop="telephone">+7 7212 12–34–56,</span><br>
  Факс: <span itemprop="faxNumber">+7 7212 12–34–57,</span><br>
  Электронная почта: <span itemprop="email">mail@mymail.ru</span>
</div>
</div>

<h2>Дислокация</h2>
<div id="ymap" class="border_maps" style="width:85%;height:320px; padding: 5px; margin: 5px;"></div>
<p><b>Ваше местоположение по IP</b></p>
<div id="map" style="width:400px; height:300px"></div>

<style type="text/css">
label.error {
	display: block;
	color: red;
}
</style>

<!--
      Настройте параметры местоположения офиса на карте

-->
<script src="https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
		<script type="text/javascript">
			ymaps.ready(init);
			function init () {
				var myMap = new ymaps.Map("ymap", {
					center: [49.796295, 73.083709], // координаты центра карты определить здесь https://api.yandex.ru/maps/tools/getlonglat/
					zoom: 16, // коэффициент масштабирования
					type: 'yandex#map' // тип карты
				}),

				myPlacemark = new ymaps.Placemark([49.796295, 73.083709], { // координаты объекта
					// Свойства
					iconContent: ''
				}, {
					// Опции
					preset: 'twirl#blueStretchyIcon' // иконка растягивается под контент
				});

                                // Добавляем метку на карту
				myMap.geoObjects.add(myPlacemark);
				myMap.controls
				.add('typeSelector')
				.add('smallZoomControl', { right: 5, top: 75 })
				.add('mapTools');

			}
		</script>
<script type="text/javascript">
ymaps.ready(init);

function init() {
    // Данные о местоположении, определённом по IP
    var geolocation = ymaps.geolocation,
    // координаты
        coords = [geolocation.latitude, geolocation.longitude],
        myMap = new ymaps.Map('map', {
            center: coords,
            zoom: 10
        });

    myMap.geoObjects.add(
        new ymaps.Placemark(
            coords,
            {
                // В балуне: страна, город, регион.
                balloonContentHeader: geolocation.country,
                balloonContent: geolocation.city,
                balloonContentFooter: geolocation.region
            }
        )
    );
}
</script>





  <style type="text/css">
    div.activ {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
    }
    div.normal {
	background-color: transparent;
	font-weight: normal;
	color: #FFFFFF;
	font-size: 1px;
    }
  </style>