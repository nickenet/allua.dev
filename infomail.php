<? // WR-Counter v 1.0  //  03.09.06 г.  //  Miha-ingener@yandex.ru

#error_reporting (E_ALL);

include( "./defaults.php" );

$months=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
$deldt=mktime()-$days*86400; // формируем дату удаления объявления

function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;}


$i=0;
if ($handle = opendir($datadir)) {
while (($file = readdir($handle)) !== false)
if (!is_dir($file)) {$lines[$i]=$file; $i++;}
closedir($handle);
} else {print 'В папке, которую вы указали нет данных счётчика!';}

$itogo=count($lines); $k=0; $text=null;

do {
$fline=file("$datadir/$lines[$k]");
$fitogo=count($fline);
if ($fitogo!=0 and $lines[$k]!="all.dat" and $lines[$k]!="last.dat" and $lines[$k]!="mainbase.dat") {
$thendayx=str_replace(".dat","",$lines[$k]);
$dt=explode(".",$thendayx);
$then=mktime(0,0,0,$dt[1],$dt[0],$dt[2]);
$tekdate=date("d.m.Y",$then);

// Удаляем старые данные
if ($deldt>$then) {unlink ("$datadir/$lines[$k]");}

// Блок считает ХОСТЫ (уникальных посетителей)
usort($fline,"prcmp");
$numip="0"; $numsys="0"; $hi=0;  $ab="0"; $ac="0";

do {
$dt=explode("|",$fline[$hi]); 
if ($ab!=$dt[0]) {$ab=$dt[0]; $numip++;}
if (isset($dt[2])) {if ($ac!=$dt[2]) {$ac=$dt[2]; $numsys++;}}
$hi++;
} while ($hi<$fitogo);

$text.="$then|$fitogo|$numip|$numsys|\r\n";
}
$k++;
} while ($k<$itogo);


$fp=fopen("$datadir/mainbase.dat","w");
flock ($fp,LOCK_EX);
fputs($fp,"$text");
fflush ($fp);//очищение файлового буфера
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/mainbase.dat", 0644);


// сортируем данные 
$lines=file("$datadir/mainbase.dat");
$maxi=count($lines); usort($lines,"prcmp");

$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$cnturl="http://$host$self";
$cnturl=str_replace("infomail.php", "counter.php", $cnturl);



// Формируем статистику посещений (ХИТЫ/ХОТСЫ)
$msg="<HTML><head><META content='text/html; charset=windows-1251' http-equiv=Content-Type><style>BODY {FONT-FAMILY: Verdana; FONT-SIZE: 11px} TD {FONT-SIZE: 10px}</style></head>
<BODY text=#000000 leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginheight=0 marginwidth=0><center>
<B>Информация по посещаемости сайта</B><BR>Сгенерирована по данным счётчика за $days дней: <a href='$cnturl'>$cnturl</a>
<TABLE cellSpacing=0 cellPadding=0 width='98%'><TR><TD>\r\n";

// выводим 1 график - ХИТЫ
$msg.="<table cellSpacing=0 cellPadding=0 align=center><tr height=250 align=center valign=bottom><TD valign=middle>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>И<BR>Т<BR>О<BR>В</TD>\r\n";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
$dttn=round($dtt[1]*$scale1);
$msg.="<TD><table cellPadding=0><TR><TD align=center>$dtt[1]</TD></TR><TR><TD><table cellPadding=0><TR><TD height=$dttn width=15 bgcolor=#A46C7A>&nbsp;&nbsp;&nbsp;&nbsp;</TD></TR></table></TD></TR></TABLE></td>\r\n";
}
$msg.="</TR><TR><TD align=center>Дата</TD>\r\n";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$dtt[0]=date("d",$dtt[0]);
$msg.="<td align=center>$dtt[0]</TD>\r\n"; }

$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
$msg.="</tr><TR><TD>Месяц</TD><TD align=center colspan=$i>$mm1 $mm2</TD></TR></TABLE>\r\n";


// выводим 2 график - ХОСТЫ
$msg.="<table cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>О<BR>С<BR>Т<BR>О<BR>В</TD>\r\n";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
$dttn=round($dtt[2]*$scale2);
$msg.="<TD><table cellPadding=0><TR><TD align=center>$dtt[2]</TD></TR><TR><TD><table cellPadding=0><TR><TD height=$dttn width=15 bgcolor=#5193BF>&nbsp;&nbsp;&nbsp;&nbsp;</TD></TR></table></TD></TR></TABLE></td>\r\n";
}
$msg.="</TR><TR><TD align=center>Дата</TD>\r\n";

for ($i=0; $i<count($lines);$i++)  {
$dtt=explode("|",$lines[$i]);
if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$dtt[0]=date("d",$dtt[0]);
$msg.="<td align=center>$dtt[0]</TD>\r\n"; }

$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
$msg.="</tr><TR><TD>Месяц</TD><TD align=center colspan=$i>$mm1 $mm2</TD></TR></TABLE>\r\n";

$msg.="</TD></TR></TABLE>
</center>P.S. <B>Хиты</B> - кол-во посещений страниц где установлен счётчик;<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <B>Хосты</B> - кол-во посетителей с уникальным IP-адресом.<BR>
* Данное сообщение сгенерировано и отправлено роботом, отвечать на него не нужно.<BR><BR>
</TD></TR></table>
</body></html>";


$text=mktime();
$fp=fopen("$datadir/last.dat","w");
flock ($fp,LOCK_EX);
fputs($fp,"$text");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir/last.dat", 0644);

$headers=null; // Настройки для отправки писем
$headers.="Content-Type: text/html; charset=windows-1251\r\n";
$headers.="From: Администратор <".$adminemail.">\r\n";
$headers.="X-Mailer: PHP/".phpversion()."\r\n";

//print"$msg";
mail("$adminemail", "Статистика за неделю ($cnturl)",$msg,$headers);
?>
