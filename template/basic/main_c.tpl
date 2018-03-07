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


 <br />

  <table cellspacing="10" cellpadding="10" border="0" width="90%">

    <tr>
     <td align="left" valign="top" width="60%">

     *logo* <br /><br />

      <h1 style="color: green;">*company*</h1>  
      *case*
      <p>*description*</p>

	<br />

      *address*<br />
      *city* *state* *zip*<br />
      *country*<br />

       <br />
       <br />
       <br />

      Контактное лицо: *contact*<br />

	<br />

      Телефон: *phone*<br />
      Факс: *fax*<br />
      Мобильный: *mobile*<br />

	<br />

	*icq*

	<br />

<br />*filiallist*

<!--
      Workers: *reserved_1*<br />
      Since *reserved_2*<br />
      Working hours: *reserved_3*<br />
-->

<br />

*sxema* 
<br />

*map*
<br /><br />

*Yandex_map_wym250_hym200*<br>
*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*<br>

*cats*

<br />
<div align="right">
Просмотров всего: *hits*<br />
Просмотров за месяц: *hits_m*<br />
Просмотров за сегодня: *hits_d*<br />
</div>

     </td>

 <td align="left" valign="top" class="border">

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/inews.gif>
   </td>
   <td valign=center> *newslist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/itender.gif>
   </td>
   <td valign=center> *tenderlist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/iboard.gif>
   </td>
   <td valign=center> *boardlist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/ijob.gif>
   </td>
   <td valign=center> *joblist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/ipr.gif>
   </td>
   <td valign=center> *pressrellist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/products.gif>
   </td>
   <td valign=center> *productslist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/images.gif>
   </td>
   <td valign=center> *imageslist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/xls.gif>
   </td>
   <td valign=center> *exellist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/video.gif>
   </td>
   <td valign=center> *videolist*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/mail.gif>
   </td>
   <td valign=center> *mail*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/www.gif>
   </td>
   <td valign=center> *www*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/addreview.gif>
   </td>
   <td valign=center> *addreview*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/viewreviews.gif>
   </td>
   <td valign=center> *viewreviews* *rev_good**rev_bad*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/print.gif>
   </td>
   <td valign=center> *print*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
  <tr>
   <td valign=center>
    <img src=*path_to_images*/mail2.gif>
   </td>
   <td valign=center> *friend*
   </td>
  </tr>
 </table>

 <table cellspacing=0 cellpadding=3 border=0>
   <td valign=center>
    <img src=*path_to_images*/kodtop.gif>
   </td>
   <td valign=center> <a href="javascript:ShowOrHide('options','')">Получить код для рейтинга</a>
   </td>
  </tr>
<tr id='options' style='display:none;'>
<td></td><td> <textarea name="textarea" cols="32" rows="10">*kodirating*</textarea></td>
</tr>
 </table>

  <br />
 
  <br />

     <center>
      *rating*
       <br />
       <br />
      *rate*<br><br>
*img_social_link* *twitter* *facebook* *vkontakte* *odnoklassniki*
     </center>
<br>
Метки: *keywords*

    </td>
   </tr>



  </table> 

 <br />

*notepad* | <noindex><a rel="nofollow" href="*link_to_complaint*">*text_to_complaint*</a></noindex>

<br><br>

<div align="left">
*related_firms*
</div>