<?php 

/*
=====================================================
 HOLIDAYS.php
-----------------------------------------------------
 Внедрение и модификация I-Soft
=====================================================
 Назначение: отоброжение ближайших праздников
=====================================================
*/

$klvmsg="5";  // Сколько выводить дат?
$klvdays="25";  // Максимальное удалённое событие, дней 
$datafile="./system/holidays.dat"; // Имя файла базы данных


$date=date("d.m.Y"); // число.месяц.год
$time=date("H:i:s"); // часы:минуты:секунды


$holidays_title="Ближайшие праздники";

table_top ($holidays_title);
 

$day=$date=date("d"); // день
$month=$date=date("m"); // месяц
$year=$date=date("Y"); // год


if ($month==12) {$year++;} // Чтобы верно считал январские праздники
$vchera=$day-1;
$klvchasov=$klvdays*30;
$lines=file($datafile);
$itogo=count($lines); $i=0;

do {$dt=explode("|",$lines[$i]);

$todaydate=date("d.m.Y");
$tekdt=time();

$newdate=mktime(0,0,0,$dt[1],$dt[0],$year);
$dayx=date("d.m",$newdate); // конверируем дни до праздника в человеческий формат
$hdate=ceil(($newdate-$tekdt)/3600); // через сколько ЧАСОВ наступит событие
$ddate=ceil($hdate/24); // считаем сколько дней до события

// приводим слово ДЕНЬ/ДНЯ/ДНЕЙ к нужному типу
$dney="дней"; if ($ddate=="1" or $ddate=="21" or $ddate=="31") {$dney="день";} if ($ddate=="2" or $ddate=="3" or $ddate=="4" or $ddate=="22" or $ddate=="23" or $ddate=="24") {$dney="дня";}

if (($dt[0]==$vchera) and ($dt[1]==$month)) {print"Вчера был праздник: $dt[3]<BR>";}
if (($dt[0]==$day) and ($dt[1]==$month)) 
{
IF ($dt[2]=="o") {
print"Сегодня праздник: <strong><font color=red>$dt[3]</font></strong><BR>";}
else
print"Сегодня праздник: <strong>$dt[3]</strong><BR>";
}

if ($klvmsg>1) {
if ($ddate==1) {
IF ($dt[2]=="o") {
print"Завтра праздник: <strong><font color=red>$dt[3]</font></strong><BR>";}
else
print"Завтра праздник: <strong>$dt[3]</strong><BR>";
}

if (($hdate>1) and ($hdate<$klvchasov) and ($ddate!=1)) {
if (!isset($m1)) {print"Через:<BR>"; $m1=1;}
$klvmsg--;
IF ($dt[2]=="o"){
print"$ddate $dney <B>$dayx</B> - <font color=red>$dt[3]</font><BR>";
} else
{
print"$ddate $dney <B>$dayx</B> - $dt[3]<BR>";
}
} }

$i++;
} while($i<$itogo);
echo "<br><br>";

table_bottom();
?>