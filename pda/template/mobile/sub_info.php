<? /*

Шаблон вывода верхей части категорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<script type="text/javascript">
(function($) {

	$.fn.scrollPagination = function(options) {

		var settings = {
			nop     : 5, // Количество запрашиваемых из БД записей
			offset  : 0, // Начальное смещение в количестве запрашиваемых данных
			error   : 'Записей больше нет!', // оповещение при отсутствии данных в БД
			delay   : 500, // Задержка перед загрузкой данных
			scroll  : true // Если true то записи будут подгружаться при прокрутке странице, иначе только при нажатии на кнопку
		}
		if(options) {
			$.extend(settings, options);
		}
		return this.each(function() {

			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false;
			if($settings.scroll == true) $initmessage = 'Показать больше';
			else $initmessage = 'Кликни';

			$this.append('<div class="content_lenta"></div><div class="loading-bar">'+$initmessage+'</div>');

			function getData() {
				$.post('lenta.php', {
				    action        : 'scrollpagination',
				    number        : $settings.nop,
				    offset        : offset
				}, function(data) {
					$this.find('.loading-bar').html($initmessage);
					if(data == "") {
						$this.find('.loading-bar').html($settings.error);
					}
					else {
					    offset = offset+$settings.nop;
					   	$this.find('.content_lenta').append(data);
						busy = false;
					}
				});
			}
			getData();

			if($settings.scroll == true) {
				$(window).scroll(function() {
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						busy = true;
						$this.find('.loading-bar').html('Загрузка данных');
						setTimeout(function() {
							getData();
						}, $settings.delay);
					}
				});
			}

			$this.find('.loading-bar').click(function() {

				if(busy == false) {
					busy = true;
					getData();
				}
			});
		});
    }
})(jQuery);


$(document).ready(function() {
	$('#content').scrollPagination({
		nop     : 5, // Количество запрашиваемых из БД записей
		offset  : 0, // Начальное смещение в количестве запрашиваемых данных
		error   : 'Записей больше нет!', // оповещение при отсутствии данных в БД
		delay   : 500, // Задержка перед загрузкой данных
		scroll  : true // Если true то записи будут подгружаться при прокрутке странице, иначе только при нажатии на кнопку
	});
});

</script>

<div align="right">
<div id="flavor-nav" class="wrapper-dropdown"><span><? echo $def_mob_filter; ?></span>
    <ul class="dropdown">
        <li><a rel="all"><? echo $def_mob_all; ?></a></li>
        <li><a rel="news"><? echo $def_info_news; ?></a></li>
        <li><a rel="tender"><? echo $def_info_tender; ?></a></li>
        <li><a rel="board"><? echo $def_info_board; ?></a></li>
        <li><a rel="job"><? echo $def_info_job; ?></a></li>
        <li><a rel="pressrel"><? echo $def_info_pressrel; ?></a></li>
    </ul>
</div>
</div>

<div id="content_lenta"></div>

