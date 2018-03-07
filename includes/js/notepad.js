function notepadCurId()
{
	var elm = document.getElementById('notepad_link');

	if (!elm)
	{
		return false;
	}

	elm = elm.onclick.toString();
	var tmp = 'notepadAdd(';

	elm = elm.substring(elm.indexOf(tmp) + tmp.length, elm.length);
	elm = elm.substring(0, elm.indexOf(')'));

	return parseInt(elm);
}

function notepadGet()
{
	var data = '', saver = 'notepad=', cookie = '' + unescape(document.cookie);
	var offset = cookie.indexOf(saver);

	if (offset != -1)
	{
		var end = cookie.indexOf(';', offset);
		if (end == -1)
		{
			end = cookie.length;
		}

		data = cookie.substring(offset + saver.length, end);
	}

	return data;
}

function notepadInit()
{
	var data = notepadGet();
	var total = 0, p = data.length, off = 0;
	var cur_date = new Date();

	while (p != -1)
	{
		off = p;
		if (++total > notepad_max)
		{
			data = data.substring(off + 1, data.length);
			--total;
		}

		p = data.lastIndexOf(',', --off);
	}

	cur_date.setTime(cur_date.getTime() + notepad_time * 1000);
	document.cookie = 'notepad=' + data + '; path=/; expires=' + cur_date.toGMTString();

	if ( !document.getElementById('notepad_empty') )
	{
		return;
	}

	if (data == '')
	{
		document.getElementById('notepad_empty').style.display = '';
		document.getElementById('notepad_full').style.display = 'none';
	}
	else
	{
		p = document.getElementById('notepad_num');
		p.replaceChild(document.createTextNode(total), p.firstChild);

		document.getElementById('notepad_empty').style.display = 'none';
		document.getElementById('notepad_full').style.display = '';
	}

	if ( !document.getElementById('notepad_link') )
	{
		return;
	}

	data = ',' + data + ',';
	p = notepadCurId();
	if (p && data.indexOf(',' + p + ',') != -1)
	{
		document.getElementById('notepad_link').style.display = 'none';
		document.getElementById('notepad_link_del').style.display = '';
	}
	else
	{
		document.getElementById('notepad_link').style.display = '';
		document.getElementById('notepad_link_del').style.display = 'none';
	}
}


function notepadAdd(num)
{
	num = parseInt(num);
	if (num <= 0)
	{
		return false;
	}

	var data = notepadGet();
	var cur_date = new Date();

	if (data != '')
	{
		data = ',' + data + ',';
	}

	if (data.indexOf(',' + num + ',') == -1)
	{
		cur_date.setTime(cur_date.getTime() + notepad_time * 1000);
		document.cookie = 'notepad=' + data.substring(1, data.length) + num + '; path=/; expires=' + cur_date.toGMTString();
		notepadInit();
	}

	return false;
}

function notepadDel(num)
{
	num = parseInt(num);
	if (num <= 0)
	{
		return false;
	}

	var data = notepadGet();
	var cur_date = new Date();

	if (data != '')
	{
		data = ',' + data + ',';
	}

	if (data.indexOf(',' + num + ',') != -1)
	{
		cur_date.setTime(cur_date.getTime() + notepad_time * 1000);
		data = data.replace(num + ',', '');
		data = (data == ',' ? '' : data.substring(1, data.length - 1));

		document.cookie = 'notepad=' + data	+ '; path=/; expires=' + cur_date.toGMTString();
		notepadInit();
	}

	return false;
}