<? /*

Шаблон формы поиска по фирмам

*/ ?>

<form name="search" action="*file_find*" method="post" class="form-inline has-warning" role="form">
   <div class="form-group">
    *text_find*
    <input type="text" id="autocomplete" class="form-control" style="width:485px;" name="skey" value="*rezult*" maxlength="64">
   </div>
   <div class="form-group">
    <select name="location" style="width:185px;" class="form-control">*select_location*</select>
   </div>
   <div class="form-group">
    <input type="submit" name="submit" class="btn btn-danger" value="*button_search*">
   </div>
</form>
<hr>