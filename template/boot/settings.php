<?php

/* *********************************************************************
*
*  Шаблон Basic
*
********************************************************************** */

 $def_style = " <link rel=\"stylesheet\" href=\"$def_mainlocation/template/$def_template/css.css\">";

 $def_background="#FFFFFF";

 $def_help_background="#FFFFFF";

 $def_box_background="#FFFFFF";

 $def_status_color="#FFFFFF";

 $def_status_font_color="#FFFFFF";

 $def_kurs_text="#FFFFFF";

 $def_kurs_background="#223388";

 $def_letter_bg="#757575";

 $def_form_header_fontsize="1";

 $def_form_header_font="verdana"; 

 $def_form_header_color="#F1F1F1";

 $def_form_back_color="#F1F1F1";

 $def_form_back_color_search="#FFF";

 $def_form_back_color_premium="#F1F1F1";

 $def_subm_form_size="300";

 $def_update_form_size="300";

 $def_search_form_size="300";


// Боковые блоки

function table_top ($item)

 {

echo '';

 }

function table_bottom ()

 {

echo '';

 }

// Главные блоки

function main_table_top ($item)

 {

echo '<div class="block-companies"><div class="btitle"></div>';


 }

function main_table_bottom ()

 {
    
echo'</div>';

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