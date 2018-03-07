<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: counter.php
-----------------------------------------------------
 Назначение: Счетчик статистики
=====================================================
*/

$timing_start = explode(' ', microtime());

session_start();

require_once './defaults.php';

$help_section = (string)$counter_help;

$title_cp = 'Счетчик статистики - ';
$speedbar = ' | <a href="counter.php?REQ=auth">Счетчик статистики</a>';

check_login_cp('5_2','counter.php?REQ=auth');

require_once 'template/header.php';

table_item_top ("Счетчик статистики",'votes.png');

$host=$_SERVER["HTTP_HOST"]; $self=$_SERVER["PHP_SELF"];
$sburl="http://$host$self";
$sburl=str_replace("/counter.php", "", $sburl);

function prcmp ($a, $b) {if ($a==$b) return 0; if ($a<$b) return -1; return 1;}

$shapka="
<table width=100% cellpadding=1 cellspacing=0>
<tr><td width=100%>
";

?>
<link href="template/tabcss.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(function () {
    var tabContainers = $('div.tabs > div');
    tabContainers.hide().filter(':first').show();

    $('div.tabs ul.tabNavigation a').click(function () {
        tabContainers.hide();
        tabContainers.filter(this.hash).show();
        $('div.tabs ul.tabNavigation a').removeClass('selected');
        $(this).addClass('selected');
        return false;
    }).filter(':first').click();
});
</script>

<div class="tabs">
    <ul class="tabNavigation">
        <li><a class="" href="#first"><img src="images/stats.png" width="22" height="22" align="absmiddle" /> Статистика хиты/хосты</a></li>
        <li><a class="" href="#second"><img src="images/key_password.png" width="22" height="22" align="absmiddle" />Конфигурация</a></li>
        <li><a class="" href="#third"><img src="images/plug.png" width="22" height="22" align="absmiddle" />Код счетчика</a></li>
    </ul>
    <div id="first">
<?

$months=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");

$deldt=mktime()-$days*86400; // формируем дату удаления объявления

$i=0; if ($handle = opendir($datadir_cp)) {
while (($file = readdir($handle)) !== false)
if (!is_dir($file)) {$lines[$i]=$file; $i++;}
closedir($handle);
} else {print 'В папке, которую вы указали нет данных счётчика!';}

$itogo=count($lines); $k=0; $text=null;


do {
$fline=file("$datadir_cp/$lines[$k]");
$fitogo=count($fline);

if ($fitogo!=0 and $lines[$k]!="all.dat" and $lines[$k]!="last.dat" and $lines[$k]!="mainbase.dat")
{
$thendayx=str_replace(".dat","",$lines[$k]);
$dt=explode(".",$thendayx);
@$then=mktime(0,0,0,$dt[1],$dt[0],$dt[2]);
$tekdate=date("d.m.Y",$then);

// Удаляем старые данные
if ($deldt>$then) {unlink ("$datadir_cp/$lines[$k]");}

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


$fp=fopen("$datadir_cp/mainbase.dat","w");
flock ($fp,LOCK_EX);
fputs($fp,"$text");
fflush ($fp);//очищение файлового буфера
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$datadir_cp/mainbase.dat", 0644);


// сортируем данные
$lines=file("$datadir_cp/mainbase.dat");
$maxi=count($lines);
usort($lines,"prcmp");


print"$shapka";

print"<center><B>Информация по посещаемости</B></tr></td></table><TABLE border=0 cellSpacing=0 cellPadding=0 width=\"98%\"><TR><TD>";

if ($gtype=="1") {

// выводим 1 график - ХИТЫ
print"<table border=0 cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>О<BR>С<BR>Т<BR>О<BR>В</TD><TD><img src='../images/v1scale.gif' border=0></TD>";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
$dttn=round($dtt[1]/2);
print"<TD><table cellSpacing=2 cellPadding=0 border=0><TR><TD align=center><small>$dtt[1]</small></TD></TR><TR><TD><img src='../images/v1.gif' height=$dttn width=18></TD></TR></TABLE></td>";
}
print"</TR><TR><TD align=center><small>Дата</TD><TD>&nbsp;</TD>";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$dtt[0]=date("d",$dtt[0]);
print"<td align=center><small>$dtt[0]</small></TD>"; }

$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
print"</tr><TR><TD><small>Месяц</TD><TD>&nbsp;</TD><TD align=center colspan=$i>$mm1 $mm2</TD></TR></TABLE>";

// выводим 2 график - ХОСТЫ

print"<table border=0 cellSpacing=0 cellPadding=0 align=center><tr align=center valign=bottom><TD valign=middle><small>К<BR>О<BR>Л<BR>-<BR>В<BR>О<BR><B><BR>Х<BR>И<BR>Т<BR>О<BR>В</TD><TD><img src='../images/v2scale.gif' border=0></TD>";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
$dttn=round($dtt[2]*2);
print"<TD><table cellSpacing=2 cellPadding=0 border=0><TR><TD align=center><small>$dtt[2]</small></TD></TR><TR><TD><img src='../images/v2.gif' height=$dttn width=18></TD></TR></TABLE></td>";
}
print"</TR><TR><TD align=center><small>Дата</TD><TD>&nbsp;</TD>";

for ($i=0; $i<count($lines);$i++)  {
$dtt=explode("|",$lines[$i]);
if (!isset($m0)) {$m0=date("m",$dtt[0])-1;}
if ($i==$maxi-1) {$m1=date("m",$dtt[0])-1;}
$dtt[0]=date("d",$dtt[0]);
print"<td align=center><small>$dtt[0]</small></TD>"; }

$mm1=$months[$m0]; $mm2=$months[$m1]; if ($mm1==$mm2) {$mm1="";} else {$mm1.=" - ";}
print"</tr><TR><TD><small>Месяц</TD><TD>&nbsp;</TD><TD align=center colspan=$i>$mm1 $mm2</TD></TR></TABLE>";
print "</td></tr></table>";

}  else   {  // $gtype!="1"

// выводим 1 график - ХИТЫ
print" <table border=0 align=center><tr align=center><td width=70><B>ДАТА</B></td><td><B>ХИТЫ</B></td><TD><B>Кол-во</B></TD></tr>
<tr><TD>&nbsp;</TD><TD><img src='images/g1scale.gif' border=0></TD></TR>";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
print"<tr>
<TD>$dtt[0]</TD>
<td><table cellSpacing=0 cellPadding=0 border=0><TR><TD><img src='images/g1.gif' height=18 width=$dtt[1]></TD><TD align=center>&nbsp; $dtt[1]</TD></TR></TABLE></td>
</tr>"; }

// выводим 2 график - ХОСТЫ
print"</table><BR> <table border=0 align=center><tr align=center><td width=70><B>ДАТА</B></td><td><B>ХОСТЫ</B></td><TD><B>Кол-во</B></TD></tr>
<tr><TD>&nbsp;</TD><TD><img src='images/g2scale.gif' border=0></TD></TR>";

for ($i=0; $i<$maxi; $i++)  {
$dtt=explode("|",$lines[$i]);
$dtt[0]=date("d.m.y",$dtt[0]);
$dttn=$dtt[2]*5;
print"<tr><td>$dtt[0]</TD>
<td><table cellSpacing=0 cellPadding=0 border=0><TR><TD><img src='images/g2.gif' height=18 width=$dttn></TD><TD align=center>&nbsp; $dtt[2]</TD></TR></TABLE></td>
</tr>";
print"</table><BR>";
print "</td></tr></table>";
}

}

?>
    </div>
    <div id="second">
<?

// Получаем цвета для отображения
$s1=dechex($s1r); $s1.=dechex($s1g); $s1.=dechex($s1b);
$s2=dechex($s2r); $s2.=dechex($s2g); $s2.=dechex($s2b);
$s3=dechex($s3r); $s3.=dechex($s3g); $s3.=dechex($s3b);
if ($image=="counter1.png") {$i1="checked";} else {$i1="";}
if ($image=="counter2.png") {$i2="checked";} else {$i2="";}
if ($image=="counter3.png") {$i3="checked";} else {$i3="";}
if ($image=="counter4.png") {$i4="checked";} else {$i4="";}
if ($image=="counter5.png") {$i5="checked";} else {$i5="";}
if ($image=="counter6.png") {$i6="checked";} else {$i6="";}
if ($image=="counter7.png") {$i7="checked";} else {$i7="";}
if ($image=="counter8.png") {$i8="checked";} else {$i8="";}

if ($sendstat=="1") {$m1="checked"; $m2="";} else {$m2="checked"; $m1="";}
if ($gtype=="1") {$g1="checked"; $g2="";} else {$g2="checked"; $g1="";}
print "$shapka
<table border=0 width=750 cellpadding=0 cellspacing=0>
<tr>
<td id=table_files><B>Переменная</B></td>
<td id=table_files_r><B>Значение</B></td>
</tr>
<tr>
<td id=table_files_i>Емайл админа</td>
<td id=table_files_i_r><input type=text value='$adminemail' name=adminemail size=30></td>
</tr>
<tr>
<td id=table_files_i>Мылить статистику админу? Периодичность?</td>
<td id=table_files_i_r><input type=radio name=sendstat value=\"1\"$m1> да&nbsp; <input type=radio name=sendstat value=\"0\"$m2> нет
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text value='$sendday' name=sendday size=5> (через 1,2,3 дней и т.д.)</td>
</tr>
<tr>
<td id=table_files_i>Тип графика</td>
<td id=table_files_i_r><input type=radio name=gtype value=\"1\"$g1> вертикальный&nbsp; <input type=radio name=gtype value=\"0\"$g2> горизонтальный</td>
</tr>
<tr>
<td id=table_files_i>Коэффициент масштабирования<BR> графика ХИТОВ / ХОСТОВ ?</td>
<td id=table_files_i_r><input type=text value='$scale1' name=scale1 size=5> &nbsp;&nbsp;&nbsp; .:. &nbsp;&nbsp;&nbsp; <input type=text value='$scale2' name=scale2 size=5> &nbsp; &nbsp; По умолчанию: <B><U>0.5</U> и <U>2</U></B>.</td>
</tr>
<tr>
<td id=table_files_i>Сколько суток хранить статистику?</td>
<td id=table_files_i_r><input type=text value='$days' name=days size=5></td>
</tr>
<tr>
<td id=table_files_i>Путь к папке с данными</td>
<td id=table_files_i_r><input type=text value='$datadir' name=datadir size=15> &nbsp; &nbsp; По умолчанию: &quot<B><U>./data</U></B>&quot.</td>
</tr>
<tr>
<td id=table_files_i>файл с рисунком счётчика</td>
<td id=table_files_i_r>
<input type=radio name=image value='counter1.png' $i1><img src='../images/counter1.png'> &nbsp;
<input type=radio name=image value='counter2.png' $i2><img src='../images/counter2.png'> &nbsp;
<input type=radio name=image value='counter3.png' $i3><img src='../images/counter3.png'> &nbsp;
<input type=radio name=image value='counter4.png' $i4><img src='../images/counter4.png'> <BR>
<input type=radio name=image value='counter5.png' $i5><img src='../images/counter5.png'> &nbsp;
<input type=radio name=image value='counter6.png' $i6><img src='../images/counter6.png'> &nbsp;
</td>
</tr>
<tr>
<td id=table_files_i>RGB цвет 1-й цифры на счётчике</td>
<td id=table_files_i_r><input type=text value='$s1r' name=s1r size=5><input type=text value='$s1g' name=s1g size=5><input type=text value='$s1b' name=s1b size=5><B><font color='$s1'>1234567890</font></B></td>
</tr>
<tr>
<td id=table_files_i>RGB цвет 2-й цифры на счётчике</td>
<td id=table_files_i_r><input type=text value='$s2r' name=s2r size=5><input type=text value='$s2g' name=s2g size=5><input type=text value='$s2b' name=s2b size=5><B><font color='$s2'>1234567890</font></B></td>
</tr>
<tr>
<td id=table_files_i>RGB цвет 3-й цифры на счётчике</td>
<td id=table_files_i_r><input type=text value='$s3r' name=s3r size=5><input type=text value='$s3g' name=s3g size=5><input type=text value='$s3b' name=s3b size=5><B><font color='$s3'>1234567890</font></B></td>
</tr>
<tr><td colspan=2><BR><center></td></tr>
</table><BR></td></tr></table>";

?>
    </div>
    <div id="third">
<?
print "$shapka <BR><BR><center>
<form><textarea rows=5 cols=60>
<!-- Код счётчика -->
<a href=\"$def_mainlocation/info.php\"><img src=\"$def_mainlocation/counter.php\" width=88 height=31 border=0></a>
<!-- ВЫШЕ код счётчика  -->
</textarea><BR><BR><BR></TD></TR></TABLE>";
?>
    </div>
</div>

<?

require_once 'template/footer.php';

?>
