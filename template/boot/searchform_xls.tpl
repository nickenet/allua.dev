<? /*

Шаблон формы поиска по прайс-листам

*/ ?>

<form action="*file_find*" method="post" class="form-inline has-warning" role="form">
   <div class="form-group">
    *text_find*
    <input type="text" name="skey" id="autocomplete" class="form-control" value="*rezult*" maxlength="60" style="width:600px;">
   </div>
   <div class="form-group">
    <input type="submit" name="submit" class="btn btn-danger" value="*button_search*">
   </div>
</form>
<hr>