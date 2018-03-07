now = new Date();

	var pad;

	if(now.getMinutes() < 10) {pad = "0"} else pad = "";

function print_date() 
{
	 var day = now.getDay();
	 var dayname;

	 if (day==0)dayname="Воскресение";
	 if (day==1)dayname="Понедельник";
	 if (day==2)dayname="Вторник";
	 if (day==3)dayname="Среда";
	 if (day==4)dayname="Четверг";
	 if (day==5)dayname="Пятница";
	 if (day==6)dayname="Суббота";

	 var monthNames = new Array(".01.",".02.",".03.",".04.",".05.",".06.",".07.",".08.",".09.",".10.",".11.",".12.");
	 var month = now.getMonth();
	 var monthName = monthNames[month];
	 var year = now.getYear();

	 if ( year < 1000 ) year += 1900;
	 var datestring = '' + dayname + '&nbsp;&nbsp; | &nbsp;&nbsp;<font color="#db0101">' + now.getDate() + '' + monthName + '' + year + '</font>&nbsp;&nbsp; | &nbsp;&nbsp;' + now.getHours() + ':' + pad + now.getMinutes() + '';
	 document.write('<NOBR>&nbsp;' + datestring + '</NOBR>');
}