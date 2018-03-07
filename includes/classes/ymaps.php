<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by K.Ilya
  =====================================================
  Файл: ymaps.php
  -----------------------------------------------------
  Назначение: Класс по работе с картами
  =====================================================
 */

class YMaps
{

	var $map_widht = 600;
	var $map_height = 300;
	var $map_zoom = 10;
	var $map_type = "map";
	var $map_center = "55.8, 37.6";
	var $firmname = "";
	var $adress = "";
	var $phone = "";
	var $link_to_big_map = "";

	// Функция создания маркера
	function showMarker()
	{
		?>

		<script src="https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"
		type="text/javascript"></script>

		<script type="text/javascript">
			ymaps.ready(init);

			function init () {
				var myMap = new ymaps.Map("map", {
					center: [<? echo $this->map_center; ?>],
					zoom: <? echo $this->map_zoom; ?>,
					type: 'yandex#<? echo $this->map_type; ?>'
				});

				myPlacemark = new ymaps.Placemark([<? echo $this->map_center; ?>], {
					hintContent: 'Укажите положение Вашей фирмы на карте, передвигая метку!'
				}, {
					draggable: true // Метку можно перетаскивать, зажав левую кнопку мыши.
				});

				myPlacemark.events.add('drag', function(e){
					show_coordinates();
				});
														
				myMap.geoObjects.add(myPlacemark);

				myMap.controls
				.add('zoomControl')
				.add('typeSelector')
				.add('smallZoomControl', { right: 5, top: 75 })
				.add('mapTools');


				$('#search_form').submit(function() {
					var search_query = $('#search_geo').val();
					ymaps.geocode(search_query, {results: 10}).then(function (res) {
						var elmCoord = res.geoObjects.get(0).geometry.getCoordinates();
						myPlacemark.geometry.setCoordinates(elmCoord);
						myPlacemark.getMap().setCenter(elmCoord);
						show_coordinates();
					}, function(error){
						alert('Ошибка: ' + error);
					});
					return false;
				});
											
				$('#loader_geo').css('visibility', 'hidden');
				$('#save_geo').submit(function(){
					$('#loader_geo').css('visibility', 'visible');
					var mapType = myPlacemark.getMap().getType().split('#');
					if (mapType.length > 1)
					{
						$('#save_geo input[name=typemaps]').val(mapType[1]);
					}
									
					if ($('#save_geo_result').length == 0)		
					{
						return;
					}
								
					$.post($('#save_geo').prop('action'), $('#save_geo').serialize(), function(result){
						var elmCoord = [$('#shirota').val(), $('#dolgota').val()];
						myPlacemark.geometry.setCoordinates(elmCoord);
						myPlacemark.getMap().setCenter(elmCoord);
						// Показываю ответ от сервера, через 3 сек. скрываю его и удаляю
						$('#save_geo_result').html(result)
						.children('.alert-success').delay(3000).slideUp(function(){$(this).remove()});
						$('#loader_geo').delay(500).css('visibility', 'hidden');
					});
							
					return false;
				});
			}
										
			function show_coordinates()
			{
				if ($('#coord_toggler').prop('checked'))
				{
					return;
				}
													
				var coord = myPlacemark.geometry.getCoordinates();
				$('#shirota').val(coord[0]);
				$('#dolgota').val(coord[1]);
			}
		</script>
		<?
	}

	// Функция показа карты
	function showMap()
	{
		$view_map_script="
		<script src=\"https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU\"
		type=\"text/javascript\"></script>
		<script type=\"text/javascript\">
			ymaps.ready(init);

			function init () {
				var myMap = new ymaps.Map(\"ymap\", {
					center: [$this->map_center],
					zoom: $this->map_zoom,
					type: 'yandex#$this->map_type'
				}),

				myPlacemark = new ymaps.Placemark([$this->map_center], {
					// Свойства
					iconContent: '$this->firmname',
					balloonContentHeader: '<b>$this->firmname<b>',
					balloonContentBody: '$this->adress<br>$this->phone',
					balloonContentFooter: '$this->link_to_big_map'
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
		</script>";

                return $view_map_script;

	}
}
?>
