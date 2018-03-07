<? // WR-Counter v 1.0  //  03.09.06 г.  //  Miha-ingener@yandex.ru

//#error_reporting (E_ALL);

include ( "conf/config.php" );

// Блок МЫЛИТ СТАТИСТИКУ АДМИНУ
$ldate="0";
if (is_file("$datadir/last.dat")) {$lline=file("$datadir/last.dat"); $li=count($lline); if ($li>0) {$ldate=$lline[0];}}
$datescribe=$ldate+7*86400; // расчитываем дату отправки
@$today=mktime();
if ($today>$datescribe) {include("infomail.php");}

function addSpace($num) {$strlen=17-strlen($num); $space=null; while($strlen) {$space.=" "; $strlen--;} return $space.$num;}

function read_file($path)
{if(!is_file($path))return false;
elseif(!filesize($path))return array();
elseif($array=file($path))return $array;
else while(!$array=file($path))sleep(1);
return $array;}

function normal_numeric($number)
{if(!isset($number))return false;
else{$strlen=strlen($number);
$new=null;
for ($i=$strlen-1;$i>-1;$i--)
{$n = $i;$n++;if(strstr($n/3,"."))$new.=$number[$strlen-1-$i];
else if($n!=$strlen)$new.=    " ".$number[$strlen-1-$i];
else$new.=$number[$strlen-1-$i];}
return $new;}}
//----- END FUNCTIONS ------//

if(!extension_loaded("gd")) {error("У Вашего хостера моуль GD не загружен - скрипт работать НЕ будет",date("Дата: d.m.Y. Время: H:i:s",time())); exit;}

$ip=(isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:0;
$a=$b=$c=null;
$today=date('d.m.Y',time());
$times=mktime();
if (isset($_SERVER["HTTP_REFERER"])) {$from=$_SERVER["HTTP_REFERER"];} else {$from="";}
//if (isset($_SERVER["HTTP_USER_AGENT"])) {$who=$_SERVER["HTTP_USER_AGENT"];} else {$who="";}
$who="";
if (isset($_SERVER["SCRIPT_NAME"])) {$gde=$_SERVER["SCRIPT_NAME"];} else {$gde="";}
if (!is_file("$datadir/$today.dat")) {$OpenToday=fopen("$datadir/$today.dat","a"); fclose($OpenToday);}

$itogo=read_file("$datadir/all.dat"); if(!isset($itogo[0])) $itogo[0]=0;
$fp=fopen("$datadir/all.dat","w"); flock ($fp,LOCK_EX); fwrite($fp,($a=$itogo[0]+1)); flock ($fp,LOCK_UN); fclose($fp); @chmod("$datadir/all.dat", 0644);
$ft=fopen("$datadir/$today.dat","a"); flock ($ft,LOCK_EX); fwrite($ft,"$ip|$times|$gde|$who|$from|\r\n"); flock ($ft,LOCK_UN); fclose($ft); @chmod("$datadir/$today.dat", 0644);
$newlines=read_file("$datadir/$today.dat"); 
for ($i=0;$i < count($newlines); $i++) {$dt=explode("|", $newlines[$i]); $lines[$i]=$dt[0];}
$b=count($lines); $c=count(array_unique($lines));

if(strlen($a)>9||!isset($a)) $a="?"; if(strlen($b)>9||!isset($b)) $b="?"; if(strlen($c)>9||!isset($c)) $c="?";

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: image/png".chr(10).chr(10));

$image=ImageCreateFromPNG("./images/".$image);

$color1=ImageColorAllocate($image,$s1r,$s1g,$s1b);
$color2=ImageColorAllocate($image,$s2r,$s2g,$s2b);
$color3=ImageColorAllocate($image,$s3r,$s3g,$s3b);

ImageString($image,1,0,2, addSpace(normal_numeric("$a")),$color1);
ImageString($image,1,0,12, addSpace(normal_numeric("$b")),$color2);
ImageString($image,1,0,21, addSpace(normal_numeric("$c")),$color3);
ImagePNG($image);
unset($time);

?>
