/**
 * Надстройка jQuery для механизма Edit in Place.
 *
 * @author: K.Ilya
 * @date:   01.12.2010
 *
 */

$(document).ready(function() {
	(function($){
		$.fn.editable = function(options){
			var defaults = {
				url: 'banner.php',
				id: 0,
				style_class: 'editable'
			};

			var options = $.extend(defaults, options);

			return this.each(function() {
				var obj = $(this);

				obj.addClass(options.style_class);

				var text_saved = obj.html();
				var namex = this.id + 'editMode';
				var items = '';

				obj.click(function() {
					if ( obj.data('canceled') || obj.hasClass('changing') )
					{
						obj.data('canceled', false);
						return false;
					}

					var inputx		= '<input id="' + namex + '" type="text" '
									+	'class="eInput" value="' + text_saved + '" /><br />';
					var btnSend		= '<input type="button" id="btnSave' + this.id + '" value="OK" /><br />';
					var btnCancel	= '<input type="button" id="btnCancel' + this.id + '" value="NO" /><br />';

					items = inputx + btnSend + btnCancel;

					obj.removeClass('changed');
					obj.addClass('changing');
					obj.html(items);

					$('#' + namex).focus().select();
					$('#' + namex).keyup(updateCtr);
					$('#btnSave' + this.id, obj).click(function() {
						$.ajax({
							type: 'POST',
							data:
							{
								new_val: $('#' + namex).val(),
								edit_click: obj.hasClass('click') ? 1 : 0,
								action: 'edit',
								id: options.id
							},
							url: options.url,
							success: function(data) {
								if (data > '')
								{
									obj.html(data).addClass('changed');
									updateCtr.call(obj);
								} 
								else
								{
									$('#message').html('Ошибка обновления.');
								}
								
								text_saved = data;
							},
							error: function(objHttpRequest, error_str) {
								$('#message').html(error_str);
							}
						});
						obj.removeClass('changing');
					})

					$('#btnCancel' + this.id, obj).click(function() {
						obj.html(text_saved);
						obj.data('canceled', true);
						obj.removeClass('changing');
						updateCtr.call(obj);
					})

					return false;
				});
			});
		};
	})(jQuery);

	$('.editable').each(function(){
		var curId = $(this).parent().parent().find('.ch_list').val().split('.')[0];

		$(this).editable({
			id: curId
		});
	});
});