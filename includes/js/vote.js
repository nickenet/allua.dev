function ajax()
{ }

ajax.prototype =
{
	req   : null,
	timer : null,
	data  : null,
	func  : null,
	wrap  : null,
	req_stop : function ()
	{
		//alert('stop');
		vote_see();
		this.req.abort();
	},
	reqChange : function ()
	{
		if (this.req.readyState == 4)
		{
			clearTimeout(this.timer);
			if (this.req.status == 200)
			{
				this.data = '' + this.req.responseText + '';
				this.req.abort();
				this.func();
			}
			else
			{
				//alert('ERR ' + this.req.status + this.req.statusText);
				vote_see();
				this.req.abort();
			}
		}
	},
	reqDoc : function (url)
	{
		if (!this.func || !this.wrap)
		{
			alert('set func!');
			return;
		}

		url += '&ajax=' + Math.random();
		if (window.XMLHttpRequest)
		{
			this.req = new XMLHttpRequest();
			this.req.onreadystatechange = this.wrap;
			this.req.open('GET', url, true);
			this.req.send(null);
		}
		else if (window.ActiveXObject)
		{
			this.req = new ActiveXObject("Microsoft.XMLHTTP");
			this.req.onreadystatechange = this.wrap;
			this.req.open('GET', url, true);
			this.req.send();
		}
		else
		{
			//alert('Cannot create request');
			vote_see();
			return;
		}

		this.timer = window.setTimeout("ajax_vote.req_stop()", 15000);
	}
}


function vote_see()
{
	$('#vote_body').css('display', 'none');
	$('#vote_results').css('display', '');
}


function vote_do()
{
	var num, tmp;

	num = 0;
	tmp = $('#vote_form')[0].vote;
	for (var i = 0; i < tmp.length; i++)
	{
		if (tmp[i].checked)
		{
			num = tmp[i].value;
		}
	}

	$('#vote_pic').css('display', '');
	tmp = $('#vote_form')[0];
	for (var i = 0; i < tmp.length; i++)
	{
		if (tmp[i].type && (tmp[i].type == 'radio' || tmp[i].type == 'submit') )
		{
			tmp[i].disabled = true;
		}
	}

	ajax_vote = new ajax();
	ajax_vote.func = function()
	{
		if (this.data.indexOf('ok') != 0)
		{
			//alert('request error ' + this.data);
			vote_see();
			return;
		}

		$('#vote_results').html(this.data.substring(2, this.data.length));
		vote_see();
	}

	ajax_vote.wrap = function()
	{
		ajax_vote.reqChange();
	}

	ajax_vote.reqDoc('vote.php?num=' + num);
	return false;
}