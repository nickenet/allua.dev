<script type="text/javascript" language="JavaScript">

  function textCounter (field, countfield, maxlimit)

  {

  	if (field.value.length > maxlimit)

  	field.value = field.value.substring(0, maxlimit);

  	else

  	countfield.value = maxlimit - field.value.length;

  }

  function newWindow (mypage,myname,w,h,features)

  {

  	if(screen.width)

  	{

  		var winl = (screen.width-w)/2;
  		var wint = (screen.height-h)/2;

  	}

  	else

  	{

  		winl = 0;wint =0;

  	}

  	if (winl < 0) winl = 0;
  	if (wint < 0) wint = 0;

  	var settings = 'height=' + h + ',';
  	settings += 'width=' + w + ',';
  	settings += 'top=' + wint + ',';
  	settings += 'left=' + winl + ',';
  	settings += features;
  	settings += ' scrollbars=yes ';

  	win = window.open(mypage,myname,settings);

  	win.window.focus();

  }

function checkemail (emailStr) 
{
var checkTLD=1;
var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
var emailPat=/^(.+)@(.+)$/;
var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
var validChars="\[^\\s" + specialChars + "\]";
var quotedUser="(\"[^\"]*\")";
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
var atom=validChars + '+';
var word="(" + atom + "|" + quotedUser + ")";
var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
var matchArray=emailStr.match(emailPat);

if (matchArray==null) 
{
alert("<? echo"$def_mail_error"; ?>");
return false;
}
var user=matchArray[1];
var domain=matchArray[2];

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
alert("<? echo"$def_mail_error"; ?>");
return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
alert("<? echo"$def_mail_error"; ?>");
return false;
   }
}

if (user.match(userPat)==null) 
{
alert("<? echo"$def_mail_error"; ?>");
return false;
}

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("<? echo"$def_mail_error"; ?>");
return false;
   }
}
return true;
}

var atomPat=new RegExp("^" + atom + "$");
var domArr=domain.split(".");
var len=domArr.length;
for (i=0;i<len;i++) {
if (domArr[i].search(atomPat)==-1) {
alert("<? echo"$def_mail_error"; ?>");
return false;
   }
}

if (checkTLD && domArr[domArr.length-1].length!=2 && 
domArr[domArr.length-1].search(knownDomsPat)==-1) {
alert("<? echo"$def_mail_error"; ?>");
return false;
}

if (len<2) {
alert("<? echo"$def_mail_error"; ?>");
return false;
}

return true;
}

</script>