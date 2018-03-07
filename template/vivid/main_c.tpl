<? /*

Шаблон информационной страницы компании для тарифа группы C

*/ ?>

<div align="center">*Yandex_map_big*</div>

<script language="javascript">

function ShowOrHide(d1, d2) {
	  if (d1 != '') DoDiv(d1);
	  if (d2 != '') DoDiv(d2);
	}
	function DoDiv(id) {
	  var item = null;
	  if (document.getElementById) {
		item = document.getElementById(id);
	  } else if (document.all){
		item = document.all[id];
	  } else if (document.layers){
		item = document.layers[id];
	  }
	  if (!item) {
	  }
	  else if (item.style) {
		if (item.style.display == "none"){ item.style.display = ""; }
		else {item.style.display = "none"; }
	  }else{ item.visibility = "show"; }
 	}
</script>

<table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="400" align="left" valign="top">*logo*</td>
                    <td width="150" align="left" valign="top">*notepad*<br><noindex><a rel="nofollow" href="*link_to_complaint*">*text_to_complaint*</a></noindex><br>
			Просмотров всего: <span class="subcat"> *hits*</span><br />
			Просмотров за месяц: <span class="subcat"> *hits_m*</span><br />
			Просмотров за сегодня: <span class="subcat"> *hits_d*</span><br />
                    *rating*<br>
                    *rate*</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center"><h1 style="color: green;">*company*</h1></td>
              </tr>
              <tr>
                <td align="right">&nbsp;*case*</td>
              </tr>
              <tr>
                <td><div align="justify">*description*</div></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20" valign="top"><img src="*path_to_images*/infor.gif" width="20" height="20"></td>
                    <td width="265" align="left" valign="top">*country*<br>
                      *zip* *state*<br>
                      <strong>*city*</strong><br>
                      <strong>*address*</strong><br>*filiallist*</td>
                    <td align="left" valign="top">Телефон: <strong>*phone*</strong><br>
                      Факс:<strong> *fax*</strong><br>
                        Мобильный: <strong>*mobile*</strong><br>
                          *icq*<br>
                            *www*<br>
                            <img src="*path_to_images*/mailtoopen.gif" width="20" height="20" align="absmiddle">*mail*</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#1F50A8"></td>
              </tr>
              <tr>
                <td height="22"><table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20"><img src="*path_to_images*/compass.gif" width="20" height="20"></td>
                    <td align="left">*sxema*<br>
                      *map* *Yandex_map_wym450_hym200*<br>*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*<br></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#1F50A8"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
<img src="*path_to_images*/produkt.gif" width="20" height="20" align="absmiddle">*productslist*<br>
<img src="*path_to_images*/gall.gif" width="20" height="20" align="absmiddle">*imageslist*<br>
<img src="*path_to_images*/excelp.gif" width="20" height="20" align="absmiddle">*exellist*<br>
<img src="*path_to_images*/video.gif" width="20" height="20" align="absmiddle">*videolist*<br>
    </td>
    <td valign="top">
<img src="*path_to_images*/inews.gif" width="20" height="20" align="absmiddle">*newslist*<br>
<img src="*path_to_images*/itender.gif" width="20" height="20" align="absmiddle">*tenderlist*<br>
<img src="*path_to_images*/iboard.gif" width="20" height="20" align="absmiddle">*boardlist*<br>
<img src="*path_to_images*/ijob.gif" width="20" height="20" align="absmiddle">*joblist*<br>
<img src="*path_to_images*/ipr.gif" width="20" height="20" align="absmiddle">*pressrellist*<br>
    </td>
  </tr>
</table>
		</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#1F50A8"></td>
              </tr>
              <tr>
                <td><table width="550" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20"><img src="*path_to_images*/tomails.gif" width="20" height="20"></td>
                    <td align="left">  *addreview* | *viewreviews* *rev_good**rev_bad* | *friend*</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#1F50A8"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>*img_social_link* *twitter* *facebook* *vkontakte* *odnoklassniki*<br>Метки: *keywords*</td>
              </tr>
              <tr>
                <td align="right"><img src="*path_to_images*/kl.gif" width="20" height="20" align="absmiddle">Контактное лицо: <strong>*contact*</strong></td>
              </tr>
              <tr>
                <td align="right">*print* <img src="*path_to_images*/print.gif" width="20" height="20" align="absmiddle"></td>
              </tr>
              <tr>
                <td>*cats*</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><img src="*path_to_images*/kod.gif" width="20" height="20" align="absmiddle"><a href="javascript:ShowOrHide('options','')">Получить код для рейтинга</a></td>
              </tr>
              <tr>
                <td id='options' style='display:none;'><textarea name="textarea" cols="32" rows="10">*kodirating*</textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
<br>
<div align="left">
*related_firms*
</div>