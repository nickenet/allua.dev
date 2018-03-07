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

$video_svaz='<select name="rec[]">';
$video_svaz.='<option value="0">Укажите название видеоролика</option>';

for ( $i=0; $i<$results_amount; $i++ ) {

    $f_v = $db->fetcharray  ( $r );

    $video_svaz.='<option value="'.$f_v['num'].'">'.$f_v['item'].'</option>';

}

$video_svaz.='</select>';
$form_message = str_replace("<br>", "\n", $form_message);

?>
<script type="text/javascript">
$(function(){

    $('#addNewField').click(function(){
       $('<li></li>')
           .append('<?=$video_svaz; ?>')
           .append('<div id="del_rol" class="icon-remove"></div>')
           .appendTo('#roliki');
    });

    $('#del_rol').live('click', function(){
        if ($(this).text() == '') {
          $(this).parent().remove();
        }
    });

});
</script>
<form action="?REQ=authorize&mod=edvideo" method="post">    
<table cellpadding="5" cellspacing="1" border="0" width="100%">
    <tr>
        <td align="right" width="80%">
          <?=$def_video_item; ?>: <font color=red>*</font><input type="text" name="item" size="45" value="<?=$form_item; ?>"><br><br>
	  <?=$def_video_url; ?>: <font color=red>*</font><textarea name="url" cols="45" rows="5" style="width:300px; height:100px;"><?=$form_urlv; ?></textarea><br><br>
          Краткое описание видеоролика: <textarea name="message" cols="45" rows="5" style="width:300px; height:100px;"><?=$form_message; ?></textarea><br><br>
          Подробное описание видеоролика: <br><br><textarea id="business" name="business" class="business" cols="20" rows="20" style="width:400px;"><?=$form_full; ?></textarea><br>
        <ul id="roliki"><?=$video_rec; ?></ul>
        <div id="addNewField" class="btn btn-info"><i class="icon-plus-sign"></i> Рекомендовать еще ролик к просмотру</div> <span class="tooltip-main well">[<a title="Выбранные видеоролики будут рекомендованы для просмотра посетителям." rel="tooltip" href="#">?</a>]</span><br>
        </td>
    </tr>
</table>
<input type="hidden" name="changed" value="true">
                </div></td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="width: 200px;">Параметры SEO</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="right">
                    <table border="0" cellspacing="2" cellpadding="2">
                        <tr>
			<td align="right">Мета-тег &lt;title&gt;:&nbsp;</td>
			<td align="left">
                            <input type="text" name="title" style="width:300px;" value="<? echo $form_metatitle; ?>" id="meta_title_content"> <span class="tooltip-main well">[<a title="Укажите название видеоролика, с кратким описанием основного содержимого." rel="tooltip" href="#">?</a>]</span>&nbsp;
			</td>
			</tr>
			<tr>
			<td align="right">Мета-тег description:&nbsp;</td>
			<td align="left">
                            <input type="text" name="descr" style="width:300px;" value="<? echo $form_metadescr; ?>" id="meta_desc_content"> <span class="tooltip-main well">[<a title="Очень кратко сформируйте описание видеролика." rel="tooltip" href="#">?</a>]</span>
			</td>
			</tr>
			<tr>
                        <td align="right" valign="top">Мета-тег keywords:&nbsp;</td>			
			<td align="left">
                            <textarea name="keywords" cols="20" rows="4" style="width:400px;" id="meta_keys_content"><? echo $form_metakeywords; ?></textarea> <span class="tooltip-main well">[<a title="Перечислите через запятую ключевые слова, которые обязательно присутствуют в описании видеролика." rel="tooltip" href="#">?</a>]</span>
			</td>
			</tr>
			<tr>
        		<td align="right">ЧПУ URL страницы:&nbsp;</td>
			<td align="left">
                        	<input type="text" name="url_seo" value="<? echo $form_name; ?>" style="width:300px;"> <span class="tooltip-main well">[<a title="ЧПУ URL ссылка для просмотра видеоролика в браузере. Допустимы только латинские символы." rel="tooltip" href="#">?</a>]</span>
			</td>
			</tr>
		    </table>

                      <div align="center"><input type="submit" name="but" value="<? if (isset($form_num)) echo $def_images_change; else echo $def_images_add; ?>" class="btn btn-warning"></div>
                      <input type="hidden" name="edit_seek" value="<?=$form_num; ?>">

</form>