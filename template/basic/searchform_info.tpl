<? /*

Шаблон формы поиска по инфоблокам

*/ ?>

<script type="text/javascript">
function trans_stat()
{
    var elm = document.getElementById('stat_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    document.getElementById('stat_link_hide').style.display = show;
    document.getElementById('stat_mod').style.display = show;
}    
</script>

<form action="search-5.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="*bgcolor*>" background="*path_to_images*/bg_searchform.gif">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td colspan="2" align="center">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="130" align="center" class="searchik">*text_find*&nbsp;</td>
            <td><input type="text" name="skey" id="autocomplete" value="*rezult*" maxlength="60" style="width:100%;"></td>
            <td width="60" align="center">&nbsp;<input type="submit" value="*button_search*"></td>
          </tr>
        </table>
	</td>
        </tr>
<rp>

      <tr>
        <td colspan="2" align="right">
<a href="javascript:;" onclick="trans_stat()" id="stat_link" class="searchik">Расширенный поиск</a>&nbsp;
<a href="javascript:;" onclick="trans_stat()" id="stat_link_hide" style="display: none" class="searchik">Расширенный поиск</a>&nbsp;
<div id="stat_mod" style="display: none">
	<table width="100%" border="0" cellspacing="2" cellpadding="1">
          <tr>
            <td width="50%" align="right" valign="top" class="searchik">*data_search1* *data_search3* *data_search5* *data_search7* *data_search9*</td>
            <td width="50%" align="right" valign="top" class="searchik">*data_search2* *data_search4* *data_search6* *data_search8* *data_search10*</td>
          </tr>
        </table>
</div>
	</td>
      </tr>

</rp>

    </table>
        <input type="hidden" name="type" value="*type_find*">
   </td>
  </tr>
</table>
</form>