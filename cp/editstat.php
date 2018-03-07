<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: editstat.php
-----------------------------------------------------
 Назначение: Редактирование стат. страницы
=====================================================
*/

$timing_start = explode(' ', microtime());

session_start();

require_once './defaults.php';

$help_section = (string)$static_help;

$title_cp = 'Редактирование страницы - ';
$speedbar = ' | <a href="editnews.php?action=list">Редактирование страницы</a>';

check_login_cp('3_1','editnews.php?action=list');

require_once 'template/header.php';

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/fset.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Статические страницы</span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34"></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="150" class="vclass"><img src="images/idedit.gif" width="31" height="31" align="absmiddle" /><a href="addstatic.php?action=addnews">Добавить страницу</a></td>
            	    <td width="220" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" /><a href="editnews.php?action=list">Редактировать страницу</a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<?

require_once('inc/function_stat.php');

 $n_to_br= TRUE;
 $use_html= TRUE;

$title=$_POST["title"];
$name_static=$_POST["name_static"];
$full_story=$_POST["full_story"];


	$full_story  = replace_news("add", $full_story, $n_to_br, $use_html);
	$name_static  = replace_news("add", $name_static, $n_to_br, $use_html);
	$title 		 = replace_news("add", $title, TRUE, $use_html);

 $news_file = "../static.dat";

$old_db = file("../static.dat");
$new_db = fopen("../static.dat",w );
foreach($old_db as $old_db_line){
	$old_db_arr = explode("|", $old_db_line);

IF ($_GET[ifdelete] != "yes") {
$id=$_POST["id"];
$ifdelete=$_GET[ifdelete];
}

IF ($_GET[ifdelete] == "yes") {
$id=$_GET[id];
$ifdelete=$_GET[ifdelete];
}

if($id != $old_db_arr[1]){
			fwrite($new_db,"$old_db_line");
  }
else
 {
		if($ifdelete != "yes")
   {
	$okchanges = TRUE;
 fwrite($new_db,"$title|$name_static|$full_story|\n");
      }
			
      }

}
fclose($new_db);

msg_text('80%',$def_admin_message_ok,"Страница <b><u><a href=\"../viewstatic.php?vs=$name_static\" target=\"_blank\">$name_static</a></u></b> была успешно изменена.");
logsto("Выполнено редактирование статической страницы <b>$name_static</b>");

require_once 'template/footer.php';

?>