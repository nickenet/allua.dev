<? /*

Шаблон формы поиска по новостям

*/ ?>

<form action="*file_find*" method="post" class="form-inline has-warning" role="form">
   <div class="form-group">
    *text_find*
    <input type="text" id="autocomplete" class="form-control" name="skey" size="20" maxlength="64" value="*rezult*" style="width: 445px;">
   </div>
   <div class="form-group">
    	<select name="category" style="width: 185px;" class="form-control">*select_razdel*</select>
   </div>
   <div class="form-group">
    <input type="submit" name="submit" class="btn btn-danger" value="*button_search*">
   </div>
</form>
<hr>