<? /*

Шаблон информационной страницы компании для тарифа группы A

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

<span class="vcard">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="42"><table width="769" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20"><img src="*path_to_images*/com_ttop_left.gif" width="20" height="42"></td>
                <td background="*path_to_images*/com_ttop_center.gif" bgcolor="#0F9DEB"><h1 class="h1title"><span class="fn org">*company*</span></h1></td>
                <td width="20"><img src="*path_to_images*/com_ttop_right.gif" width="20" height="42"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                  <tr>
                    <td align="left" style="padding:5px;"><div style="float:left; margin:5px;"><span class="logo">*logo*</span></div><div class="txt_descr">*description*</div></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding: 5px;">*rating*&nbsp;<div style="float:right"><img src="*path_to_images*/vip_company.png" width="100" height="22" align="absmiddle"></div></td>
                  </tr>
                  <tr>
                    <td><img src="*path_to_images*/users_main.png" width="22" height="22" align="absmiddle">Контактное лицо: <strong>*contact*</strong></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="*path_to_images*/comment_user_add.png" width="22" height="22" hspace="2" vspace="2" align="absmiddle">*addreview*&nbsp;<img src="*path_to_images*/comment_user.png" width="22" height="22" hspace="2" vspace="2" align="absmiddle">*viewreviews*&nbsp;*rev_good**rev_bad*<img src="*path_to_images*/volume.gif" width="22" height="22" hspace="2" vspace="2" align="absmiddle">*friend*&nbsp;</td>
                  </tr>
                  <tr >
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div style="padding:5px;">*sxema*<br>*map*</div>*Yandex_map_wym450_hym200*<br>*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*<br></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><table width="546" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="182" class="partm">*productslist*</td>
                        <td width="182" class="partm">*imageslist*</td>
                        <td width="182" class="partm">*exellist*</td>
                      </tr>
                      <tr>
                        <td width="182" class="partm">*videolist*</td>
                        <td width="182" class="partm">*newslist*</td>
                        <td width="182" class="partm">*tenderlist*</td>
                      </tr>
                      <tr>
                        <td width="182" class="partm">*boardlist*</td>
                        <td width="182" class="partm">*joblist*</td>
                        <td width="182" class="partm">*pressrellist*</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
                <td width="220" valign="top" background="*path_to_images*/bg_man_con.gif"><table width="220" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding:2px;"><table width="220" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20"><img src="*path_to_images*/g_com_top_left.gif" width="20" height="34"></td>
                        <td background="*path_to_images*/g_com_top_center.gif"><strong>Контактные данные</strong></td>
                        <td width="20"><img src="*path_to_images*/g_com_top_right.gif" width="21" height="34"></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" class="description" style="padding:5px 10px;"><div>*case*</div><span class="postal-code">*zip*</span> <span class="adr"><span class="country-name">*country*</span><br>
                      <span class="region">*state*</span><br>
                      <strong>Город:</strong> <span class="locality">*city*</span><br>
                      <strong>Адрес:</strong> <span class="street-address">*address*</span></span><br>
                      <b>*filiallist*</b><br>
                      <br>
                      <img src="*path_to_images*/telephone.png" width="16" height="16" hspace="2" vspace="2" align="absmiddle"><strong><span class="tel"><span class="value">*phone*</span></span></strong><br>
                      <img src="*path_to_images*/kfax.png" hspace="2" vspace="2" align="absmiddle"><strong>*fax*</strong><br>
                      <img src="*path_to_images*/mobile-phone.png" hspace="2" vspace="2" align="absmiddle">*mobile*<br>
                      <img src="*path_to_images*/www.png" hspace="2" vspace="2" align="absmiddle">*www*<br>
                      *icq*<br>
                      <img src="*path_to_images*/mail.png" width="22" height="22" hspace="2" vspace="2" align="absmiddle">*mail*<br>
		      *img_social_link* *twitter* *facebook* *vkontakte* *odnoklassniki*
		      <br><br>
		      Метки: *keywords*<br><br>
			<noindex><a rel="nofollow" href="*link_to_complaint*">*text_to_complaint*</a></noindex>
		     </td>
                  </tr>
                  <tr>
                    <td align="right" class="description" style="padding:5px 10px;"><img src="*path_to_images*/code.gif" width="22" height="22" hspace="2" vspace="2" align="absmiddle"><a href="javascript:ShowOrHide('options','')">Получить код для рейтинга</a></td>
                  </tr>
                  <tr id='options' style='display:none;'>
                    <td align="right" class="description" style="padding:5px 10px;"><textarea name="textarea" cols="20" rows="5" class="sideboxtext">*kodirating*</textarea></td>
                  </tr>
                  <tr>
                    <td width="220"></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="769" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20"><img src="*path_to_images*/g_com_top_left.gif" width="20" height="34"></td>
                <td width="180" background="*path_to_images*/g_com_top_center.gif"><strong>Просмотров в месяц</strong> - *hits_m*</td>
                <td width="170" align="center" background="*path_to_images*/g_com_top_center.gif">*rate*</td>
                <td width="250" align="center" background="*path_to_images*/g_com_top_center.gif"><img src="*path_to_images*/notebook.png" width="22" height="22" hspace="2" align="absmiddle">*notepad*</td>
                <td align="center" background="*path_to_images*/g_com_top_center.gif"><img src="*path_to_images*/printmgr.png" width="22" height="22" hspace="2" align="absmiddle">*print*</td>
                <td width="20"><img src="*path_to_images*/g_com_top_right.gif" width="21" height="34"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
	    <td><span class="category">*cats*</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>*related_firms*</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
</table>
</span>