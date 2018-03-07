<? /*

Шаблон - страница контактов (contact.php)

*/ ?>

<div id="send_div">
<div id="send_req">
<table width="450" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="center">Службы:<br><br>
      <select name="admin" id="admin" style="padding: 5px; font-size: 12px;">
	      <option value="1" selected>Администратор</option>
	      <option value="2">Отдел размещения рекламы</option>
  	      <option value="3">Отдел по работе с клиентами</option>
      </select>
    </td>
  </tr>
  <tr>
    <td align="center">
		<div id="adm" class="normal">Вопросы по технической части каталога</div>
		<div id="finan" class="normal">Вопросы по размещению рекламы в каталоге</div>
		<div id="reklama" class="normal">Финансовые вопросы. Договора.</div>
    </td>
  </tr>
</table>
<table cellpadding="1" cellspacing="0" border="0" width="450">
 <tr>
   <td align="right" width="40%">Ваше имя:</td>
   <td align="left" width="60%">&nbsp;<input type="text" id="name" name="name"  maxlength="50" size="35"></td>
 </tr>
 <tr>
   <td align="right" width="40%">Телефон: &nbsp;&nbsp;</td>
   <td align="left" width="60%">&nbsp;<input type="text" id="tel" name="tel" maxlength="50" size="35"></td>
 </tr>
 <tr>
   <td align="right" width="40%">E-mail: <font color=red>*</font></td>
   <td align="left" width="60%">&nbsp;<input type="text" id="mail" name="mail" maxlength="50" size="35"><br></td>
 </tr>
 <tr>
   <td align="middle" width="100%" colspan="2"><br>Ваше сообщение: <font color=red>*</font><br><br></td>
 </tr>
 <tr>
   <td align="middle" width="100%" colspan="2"><textarea name="text" cols="60" rows="10" id="text"></textarea><br></td>
 </tr>
  <tr>
   <td align="right" colspan="2">Код безопасности: <font color="red">*</font>
   *security*&nbsp;<input type="text" id="security" name="security" maxlength="15">
   </td>
  </tr>
  <tr>
   <td align="right" colspan="2"><input type="submit" id="send_form" name="inbut" value="Отправить"></td>
  </tr>
</table>
</div>
</div>
<div id="ok_send"></div>

<div align="left">
<p><b>Наши контакты:</b></p>
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

<p><b>Дислокация</b></p>
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
<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
		<script type="text/javascript">
			ymaps.ready(init);
			function init () {
				var myMap = new ymaps.Map("ymap", {
					center: [49.796295, 73.083709], // координаты центра карты определить здесь http://api.yandex.ru/maps/tools/getlonglat/
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
	background-color: #EAEAEA;
	font-weight: normal;
	color: #666666;
	font-family: Tahoma;
	font-size: 11px;
	width: 330px;
	padding-top: 3px;
	padding-right: 3px;
	padding-bottom: 3px;
	padding-left: 3px;
	border: 1px dashed #666666;
	text-align: center;
    }
    div.normal {
	background-color: transparent;
	font-weight: normal;
	color: #FFFFFF;
	font-size: 1px;
    }
  </style>