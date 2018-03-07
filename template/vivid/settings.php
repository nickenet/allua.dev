<?php

/* *********************************************************************
*
*  Шаблон vivid
*
********************************************************************** */

 $def_style = " <link rel=\"stylesheet\" href=\"$def_mainlocation/template/$def_template/css.css\">";

 $def_background="#FFFFFF";

 $def_help_background="#FFFFFF";

 $def_box_background="#FFFFFF";

 $def_status_color="#FFFFFF";

 $def_status_font_color="#1F50A8";

 $def_kurs_text="#FFFFFF";

 $def_kurs_background="#223388";

 $def_letter_bg="#757575";

 $def_form_header_fontsize="1";

 $def_form_header_font="verdana"; 

 $def_form_header_color="#F1F1F1";

 $def_form_back_color="#FAD597";

 $def_form_back_color_search="#D8F6D1";

 $def_form_back_color_premium="#F1F1F1";

 $def_subm_form_size="300";

 $def_update_form_size="300";

 $def_search_form_size="300";


// Боковые блоки

function table_top ($item)

 {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

 echo "

<table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                  <tr>
                    <td height=\"23\" background=\"$def_mainlocation/template/$def_template/images/bg_top_table_01.gif\" valign=center align=left style=\"padding-left:25px\">
		    <font face=tahoma color=#000000><b>$item</b></font>
		    </td>
                  </tr>
                  <tr>
                    <td><img src=\"$def_mainlocation/template/$def_template/images/bg_top_table_02.gif\" width=\"220\" height=\"5\"></td>
                  </tr>
                  <tr>
                    <td align=\"left\" valign=\"top\" bgcolor=\"$def_box_background\" background=\"$def_mainlocation/template/$def_template/images/bg_table.gif\" style=\"padding-left:10px\">

     <br />
";

 }

function table_bottom ()

 {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

 echo " 

    </td>
  </tr>
<tr>
        <td height=1 bgcolor=\"#36749D\"></td>
      </tr>
 </table>
<br />

";

 }

// Главные блоки

function main_table_top ($item)

 {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

 echo "
  <table width=100% cellspacing=0 cellpadding=0 border=0>
   <tr>
    <td width=\"100%\" height=\"23\" bgcolor=\"#757575\" background=\"$def_mainlocation/template/$def_template/images/bg_top_table.gif\" valign=center align=left style=\"padding-left:10px\">
            <font color=#000000><b>$item</b></font>
    </td>
  </tr>
  <tr>
    <td width=\"100%\" align=\"center\" valign=\"top\" bgcolor=\"$def_box_background\">

";

 }

function main_table_bottom ()

 {

 global $def_mainlocation;
 global $def_template;
 global $def_box_background;

 echo " 

    </td>
  </tr>
 </table>

";

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