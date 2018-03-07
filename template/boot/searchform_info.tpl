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

<form action="search-5.php" method="post" class="form-inline has-warning">
   <div class="form-group">
    *text_find*
    <input type="text" id="autocomplete" class="form-control" name="skey" size="20" maxlength="64" value="*rezult*" style="width:550px;">
   </div>
   <div class="form-group">
    <input type="submit" name="submit" class="btn btn-danger" value="*button_search*">
   </div>
<rp>
<div style="text-align: right;">
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
</div>

</rp>
        <input type="hidden" name="type" value="*type_find*">
</form>
<hr>