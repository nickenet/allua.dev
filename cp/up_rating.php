<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: up_rating.php
-----------------------------------------------------
 Назначение: Изменить рейтинг компании
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$up_rating_help;

$title_cp = 'Изменить рейтинг компании - ';
$speedbar = ' | <a href="up_rating.php">Изменить рейтинг компании</a>';

check_login_cp('4_4','up_rating.php');

require_once 'template/header.php';

table_item_top ('Изменить рейтинг компании','rating.png');

if (!$_GET['REQ'])
{

table_fdata_top ('Изменить количество просмотров фирмы');

?>

<form name=upview action="?REQ=upview" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="130" align="right">ID фирмы</td>
    <td width="120" align="left">&nbsp;
    <input name="ID_firm" type="text" size="10" /></td>
    <td colspan="2" rowspan="3" valign="top" style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:5px;">Изменяет количество просмотров фирмы на указанную величину. Например, если фирму просмотрели 10 раз, а Вы указали 25, то количество просмотров фирмы станет равным 35. Чтобы понизить количество просмотров используйте знак &quot;минус&quot; (-).</td>
  </tr>
  <tr>
    <td width="130" align="right">Количество просмотров</td>
    <td width="120"  align="left">&nbsp;
    <input name="prosmotr" type="text" size="10" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="button" id="button" value="Изменить просмотры" /></td>
  </tr>
</table>
</form>
<br />

<?

table_fdata_bottom(); echo '<br />';

table_fdata_top ('Изменить оценку  фирмы');

?>

<form name=upview action="?REQ=uprate" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="130" align="right">ID фирмы</td>
    <td width="120" align="left">&nbsp;
        <input name="ID_firm" type="text" size="10" /></td>
    <td colspan="2" rowspan="4" valign="top" style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:5px;">Изменяет оценку фирмы. Необходимо указать  оценку и сколько людей проголосовало с этой оценкой. Результаты будут прибавлены к предыдущей оценке. Например, за фирму проголосовал 1 человек с оценкой 5. При указании данных 5, 2, будет добавлено к оценке 5 + 10 = 15, голосов 1 + 2 = 3, в итоге оценка будет равна 15/3=5 (голосов 3)</td>
  </tr>
  <tr>
    <td width="130" height="22" align="right">Укажите оценку</td>
    <td width="120" align="left">&nbsp;
      <select name="prosmotr">
        <option value="5" selected>5</option>
        <option value="4">4</option>
        <option value="3">3</option>
        <option value="5">2</option>
        <option value="1">1</option>
      </select>
    </td>
  </tr>
  <tr>
    <td width="130" align="right">Укажите сколько с этой оценкой голосовало</td>
    <td width="120" align="left">&nbsp;
    <input name="golos" type="text" size="10" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="button2" id="button2" value="Изменить оценку" /></td>
  </tr>
</table>
</form>
<br />

<?

table_fdata_bottom();

}

else

{

$ID_firm=intval($_POST[ID_firm]);

$r=$db->query ("SELECT counter, hits_d, hits_m, rating, votes, firmname, selector FROM $db_users WHERE selector='$ID_firm'") or die (mysql_error());

$f=$db->fetcharray($r); 

if (($f['selector']==$_POST['ID_firm']) and ($ID_firm!=0) ) {

if ($_GET['REQ']=='upview')

{

$prosmotr=intval($_POST[prosmotr]);
$new_counter=$f['counter']+$prosmotr;
$new_hits_d=$f['hits_d']+$prosmotr;
$new_hits_m=$f['hits_m']+$prosmotr;

$db->query ("UPDATE $db_users SET counter=$new_counter, hits_d=$new_hits_d, hits_m=$new_hits_m WHERE selector=$_POST[ID_firm]") or die (mysql_error());

$s_month=date(m);
$s_month="m$s_month";
$db->query ( "UPDATE $db_stat SET $s_month = $s_month + $prosmotr WHERE firmselector='$_POST[ID_firm]'" );

logsto("Изменение рейтинга фирмы - $f[firmname] [id=$_POST[ID_firm]]");

table_fdata_top ($def_item_new_data);

echo "<br />Компания - <b>$f[firmname]</b><br /><br />";
echo "ID - <b>$_POST[ID_firm]</b><br /><br />";
echo "Просмотров до изменения: <b>$f[counter]</b><br /><br />";
echo "Просмотров после изменения: <span style=\"color:#FF0000;\"><b>$new_counter</b></span><br /><br />";
echo "Просмотров в месяц до изменения: <b>$f[hits_m]</b><br /><br />";
echo "Просмотров после изменения: <span style=\"color:#FF0000;\"><b>$new_hits_m</b></span><br /><br />";

table_fdata_bottom();

}

if ($_GET[REQ]=="uprate")

{

$new_ocenka=intval($_POST[prosmotr])*intval($_POST[golos]);
$new_ocenka=$new_ocenka+$f[rating];
$new_golos=intval($_POST[golos])+$f[votes];

$db->query ("UPDATE $db_users SET rating=$new_ocenka, votes=$new_golos WHERE selector=$_POST[ID_firm]") or die (mysql_error());

logsto("Изменение оценки фирмы - $f[firmname] [id=$_POST[ID_firm]]");

table_fdata_top ($def_item_new_data);

echo "<br />Компания - <b>$f[firmname]</b><br /><br />";
echo "ID - <b>$_POST[ID_firm]</b><br /><br />";
echo "Оценка до изменения: ";  echo show_rating ($f[rating], $f[votes]);
echo "<br /><br />Оценка после изменения: "; echo show_rating ($new_ocenka, $new_golos);
echo "<br /><br />";

table_fdata_bottom();

}

} else msg_text("80%",$def_admin_message_mess,"Указанный ID в базе не найден.");

}

require_once 'template/footer.php';

?>