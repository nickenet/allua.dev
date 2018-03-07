<?php

/* *********************************************************************
*
*  Шаблон Compact
*
********************************************************************** */


 $def_style = "<link rel=\"stylesheet\" href=\"$def_mainlocation/template/$def_template/css.css\">";

 $def_background="#FFFFFF";

 $def_status_font_color="#371E85";

 $def_kurs_background="#352A88";

 $def_form_header_fontsize="1";

 $def_form_header_font="verdana"; 

 $def_form_header_color="#F7F4FB";

 $def_form_back_color="#FFFFFF";

 $def_form_back_color_search="#352A88";

 $def_subm_form_size="300px;";

 $def_update_form_size="300px;";

 $def_search_form_size="300px;";


// Боковые блоки

function table_top ($item) {

return;

}

function table_bottom () {

return;

}

// Главные блоки

function main_table_top ($item) {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

echo '<table width="100%" cellspacing="0" cellpadding="0" border="0">
	   <tr>
	    <td width="100%" height="31" bgcolor="#FF6600" background="'.$def_mainlocation.'/template/'.$def_template.'/images/bg_top.gif" valign="top" align="left" style="padding-left:22px; padding-top:5px;">
            <font color="#352A88"><b>'.$item.'</b></font>
	    </td>
	   </tr>
      <tr>
      <td width="100%" align="center" valign="top">
';

}

function main_table_bottom () {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

 echo ' 
    </td>
  </tr>
 </table>
';

}

 function main_table_top_gal ($item)

 {

echo '<div class="block-companies"><div class="btitle">'.$item.'</div>';


 }

function main_table_bottom_gal ()

 {
    
echo'</div>';

 }

?>