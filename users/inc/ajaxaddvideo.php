<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi 
  =====================================================
  Файл: ajaxaddvideo.php
  -----------------------------------------------------
  Назначение: Ajax действия по добавлению формы видео
  =====================================================
 */

header("Content-type: text/plain; charset=windows-1251");

define ( 'ISB', true );

// Including configuration file
include ( "../../conf/config.php" );

// Including memberships
include ( "../../conf/memberships.php" );

// Including functions
include ( "../../includes/functions.php" );

// Including language pack
include ( "../../lang/language.$def_language.php" );

echo '<form action="?REQ=authorize&mod=edvideo" method="post" enctype="multipart/form-data">';
echo "<table cellpadding=\"5\" cellspacing=\"1\" border=\"0\" width=\"100%\">
           <tr>
            <td align=\"right\" width=\"80%\">
          $def_video_item: <font color=red>*</font><input type=\"text\" name=\"item\" size=\"45\"><br><br>
	  $def_video_url: <font color=red>*</font><textarea name=\"url\" cols=\"45\" rows=\"5\" style=\"width:300px; height:100px;\"></textarea><br><br>
          Краткое описание видеоролика: &nbsp;&nbsp;<textarea name=\"message\" cols=\"45\" rows=\"5\" style=\"width:300px; height:100px;\"></textarea><br>
 <br />
 </td></tr>";

echo "<tr>
         <td align=\"center\" colspan=\"3\">
         <input type=\"submit\" name=\"but\" value=\"$def_images_add\" class=\"btn btn-warning\">
          <input type=\"hidden\" name=\"changed\" value=\"true\">
          <br>
         </td>
       </tr>
      </table>
      </form>";


?>