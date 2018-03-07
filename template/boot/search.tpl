<? /*

Шаблон - расширенный поиск в каталоге

*/ ?>

<form action="search-3.php" name="search" method="post">
    <div class="form-horizontal" role="form">
        
        <div class="form-group has-default">
            *category*
            <select name="category" style="width:400px;" class="form-control">*cat_view*</select>
        </div>  
        <div class="form-group has-warning">
            *company*
            <input type="text" name="firmname" maxlength="100" class="form-control">
        </div>        
        <div class="form-group has-warning">
            *description*
            <input type="text" name="business" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-warning">
            *location*
            <select name="location" class="form-control">*location_view*</select>
        </div>
        <div class="form-group has-warning">
            *state*
            <select name="state" class="form-control">*state_view*</select>
        </div>
        <div class="form-group has-warning">
            *city*
            <input type="text" name="city" maxlength="100" class="form-control">
        </div>
       <div class="form-group has-default">
            *address*
            <input type="text" name="address" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *zip*
            <input type="text" name="zip" style="width:300px;" maxlength="15" class="form-control">
        </div>
        <div class="form-group has-default">
            *phone*
            <input type="text" name="phone" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *fax*
            <input type="text" name="fax" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *mobile*
            <input type="text" name="mobile" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *icq*
            <input type="text" name="icq" maxlength="100" class="form-control">
        </div>
        <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            &nbsp;<img src="*path_to_images*/user.png" alt="user" align="absmiddle">&nbsp;*manager*
            <input type="text" name="manager" style="width:400px;" maxlength="100" class="form-control">
        </div>
        </div>    
        <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            &nbsp;<img src="*path_to_images*/www.png" alt="user" align="absmiddle">&nbsp;*www*
            <input type="text" name="www" style="width:300px;" maxlength="100" class="form-control" placeholder="http://">
        </div>
        </div>
        <div class="form-group has-default">
            *mail*
            <input type="text" name="mail" maxlength="100" class="form-control">
        </div>             

<!-- Дополнительная переменная 1
        <div class="form-group has-default">
            *reserved_1*
            <input type="text" name="reserved_1" style="width:300px;" value="*rezult_reserved_1*" maxlength="100" class="form-control">
        </div>
-->

<!-- Дополнительная переменная 2
        <div class="form-group has-default">
            *reserved_2*
            <input type="text" name="reserved_2" style="width:300px;" value="*rezult_reserved_2*" maxlength="100" class="form-control">
        </div>
-->

<!-- Дополнительная переменная 3
        <div class="form-group has-default">
            *reserved_3*
            <input type="text" name="reserved_3" style="width:300px;" value="*rezult_reserved_3*" maxlength="100" class="form-control">
        </div>
-->
 <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *num_company_page*
            <select name="def_find_page" style="width:200px;" class="form-control"><option value="5" selected>5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select>
        </div>
 </div>     
        <div class="form-group has-warning">
                <input type="submit" id="regbut" value="*search*" class="btn btn-primary">
        </div>
    </div>
</form>