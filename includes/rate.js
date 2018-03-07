function rate(id, val)
{
	$('#rate' + id).css('display', 'none');
	$('#ratePic'+id).css('display', '');

	var func = function(data, textStatus, jqXHR)
	{
		if (data.indexOf('ok') != 0)
		{
			// alert('request error ' + data);
			// alert('Ошибка ответа');
			return;
		}

		$('#rateWrap' + id).html(data.substring(2, data.length));
	}

	jQuery.post(document.location.toString(), {'rate': id, 'val': val}, func);

	return false;
}


function seeOn(elm)
{
	do
	{
		if (elm.className.indexOf(' rateOver') == -1)
		{
			elm.className += ' rateOver';
		}

		elm = elm.previousSibling;
		if (elm && elm.nodeType == 3)
		{
			elm = elm.previousSibling;
		}
	}
	while (elm);
}


function seeOff(elm)
{
	elm = elm.parentNode.getElementsByTagName('A');
	for (i = 0; i < elm.length; ++i)
	{
		elm[i].className = elm[i].className.replace(' rateOver', '');
	}
}