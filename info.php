<?

#error_reporting (E_ALL);

include ( "./defaults.php" );


function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;}
$months=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
$deldt=mktime()-$days*86400; // формируем дату удаления объявления

$i=0; if ($handle = opendir($datadir)) {
while (($file = readdir($handle)) !== false)
if (!is_dir($file)) {$lines[$i]=$file; $i++;}
closedir($handle);
} else {print 'В папке, которую вы указали нет данных счётчика!';}
$itogo=count($lines); $k=0; $text=null;


do {
$fline=file("$datadir/$lines[$k]");
$fitogo=count($fline);

if ($fitogo!=0 and $lines[$k]!="all.dat" and $lines[$k]!="last.dat" and $lines[$k]!="mainbase.dat")
{
$thendayx=str_replace(".dat","",$lines[$k]);
$dt=explode(".",$thendayx);
$then=mktime(0,0,0,$dt[1],$dt[0],$dt[2]);
$tekdate=date("d.m.Y",$then);

// Удаляем старые данные
if ($deldt>$then) {unlink ("$datadir/$lines[$k]");}

// Блок считает ХОСТЫ (уникальных посетителей)
usort($fline,"prcmp");
$numip="0"; $numsys="0"; $hi=0; $ab="0"; $ac="0";

do {
$dt=explode("|",$fline[$hi]);
if ($ab!=$dt[0]) {$ab=$dt[0]; $numip++;}
if (isset($dt[2])) {if ($ac!=$dt[2]) {$ac=$dt[2]; $numsys++;}}
$hi++;
} while ($hi<$fitogo);

$text.="$then|$fitogo|$numip|$numsys|\r\n";
}
unset($fitogo);
unset($fline);
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
$maxi=count($lines);
usort($lines,"prcmp");

print"<HTML><head><META content='text/html; charset=windows-1251' http-equiv=Content-Type></head>
<BODY text=#000000 leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginheight=0 marginwidth=0><center>
<B>Информация по посещаемости</B>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=\"98%\"><TR><TD valign=top>";



if ($gtype=="1") {  // ВЕРТИКАЛЬНЫЙ график

$xdaym="</TR><TR><TD align=center><small>Дата</TD><TD>&nbsp;</TD>\r\n "; $graph1=""; $graph2=""; // Формируем данные для графиков
$g1shapka="<table border=0 cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>И<BR>Т<BR>О<BR>В</TD><TD><img src='images/v1scale.gif' border=0></TD>\r\n";
$g2shapka="<table border=0 cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>О<BR>С<BR>Т<BR>О<BR>В</TD><TD><img src='images/v2scale.gif' border=0></TD>\r\n";


for ($i=0; $i<$maxi; $i++)  { // начало FOR
$dtt=explode("|",$lines[$i]);

$dttn1=round($dtt[1]*$scale1);  // шкала 1-го графика
$dttn2=round($dtt[2]*$scale2); // шкала 2-го графика

$graph1.="<TD><table cellSpacing=0 cellPadding=0><TR><TD width=24 align=center><small>$dtt[1]</small></TD></TR><TR><TD align=center><img src='images/v1.gif' height=$dttn1 width=20></TD></TR></TABLE></td>\r\n";
$graph2.="<TD><table cellSpacing=0 cellPadding=0><TR><TD width=24 align=center><small>$dtt[2]</small></TD></TR><TR><TD align=center><img src='images/v2.gif' height=$dttn2 width=20></TD></TR></TABLE></td>\r\n";

if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$xday=date("d",$dtt[0]);
$xdaym.="<td align=center><small>$xday</small></TD>\r\n"; 
}  // конец FOR

$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
$msdat="</TR></TABLE><BR><center>Период: &nbsp; <B>$mm1 $mm2</B></center>\r\n";

print"$g1shapka $graph1 $xdaym </TR></TABLE>"; // печатаем 1-ый ГРАФИК
print"$g2shapka $graph2 $xdaym $msdat <BR>";   // печатаем 2-ой ГРАФИК


}  else   {  // ГОРИЗОНТАЛЬНЫЙ график


$g1shapka="<table cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>Дата</TD><TD>КОЛ-ВО <B>ХИТОВ</TD></TR><TR><TD>&nbsp;</TD><TD><img src='images/g1scale.gif' border=0></TD>\r\n";
$g2shapka="<table cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>Дата</TD><TD>КОЛ-ВО <B>ХОСТОВ</TD></TR><TR><TD>&nbsp;</TD><TD><img src='images/g2scale.gif' border=0></TD>\r\n";
$xdaym=""; $graph1=""; $graph2=""; // Формируем данные для графиков

for ($i=0; $i<$maxi; $i++)  { // начало FOR
$dtt=explode("|",$lines[$i]);

//$dtt[0]=date("d.m.y",$dtt[0]); 
if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$xday=date("d",$dtt[0]);

$dttn1=round($dtt[1]*$scale1);  // шкала 1-го графика
$dttn2=round($dtt[2]*$scale2); // шкала 2-го графика

$graph1.="<tr><TD align=center><small>$xday</small></TD><td><table cellSpacing=0 cellPadding=0><TR><TD><img src='images/g1.gif' height=16 width=$dttn1></TD><TD align=center>&nbsp; <small>$dtt[1]</small></TD></TR></TABLE></td></tr>";
$graph2.="<tr><TD align=center><small>$xday</small></TD><td><table cellSpacing=0 cellPadding=0><TR><TD><img src='images/g2.gif' height=16 width=$dttn2></TD><TD align=center>&nbsp; <small>$dtt[2]</small></TD></TR></TABLE></td></tr>";

}  // конец FOR


$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
$msdat="</tr><TR><TD colspan=2><center><small>Период:</small> <B>$mm1 $mm2</B></center>\r\n";

print"<BR>$g1shapka $graph1 $xdaym </TR></TABLE></TD><TD width='50%' valign=top> <!-- Делим экран пополам -->"; // печатаем 1-ый ГРАФИК
print"<BR>$g2shapka $graph2 $xdaym </TR></TABLE></TD>$msdat<BR>"; // печатаем 2-ой ГРАФИК

} // else ($gtype)


?>
</center>P.S. <B>Хиты</B> - кол-во посещений страниц где установлен счётчик;<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <B>Хосты</B> - кол-во посетителей с уникальным IP-адресом.<BR>
</TD></TR></table>
</body></html>
