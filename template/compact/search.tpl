<? /*

Шаблон - расширенный поиск в каталоге

*/ ?>

<form action="search-3.php" name="search" method="post">
    <table cellpadding="5" cellspacing="1" border="0" width="100%">
        <tr>
            <td bgColor="*bgcolor*" align="right">
            *category*:&nbsp;&nbsp;
                <select name="category" style="width:400px;">*cat_view*</select>
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*company*:&nbsp;<input type="text" name="firmname" style="width:300px;" maxlength="100"></td>
        </tr>
        <script type="text/javascript"><!--
        document.search.firmname.focus();
        //--></script>
        <tr>
            <td bgColor="*bgcolor*" align="right">*description*:&nbsp;<input type="text" name="business" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*location*:&nbsp;<select name="location" style="width:300px;">*location_view*</select></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*state*:&nbsp;<select name="state" style="width:300px;">*state_view*</select></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*city*:&nbsp;<input type="text" name="city" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*address*:&nbsp;<input type="text" name="address" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*zip*:&nbsp;<input type="text" name="zip" style="width:300px;" maxlength="15"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*phone*:&nbsp;<input type="text" name="phone" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*fax*:&nbsp;<input type="text" name="fax" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*mobile*:&nbsp;<input type="text" name="mobile" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*icq*:&nbsp;<input type="text" name="icq" style="width:300px;" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*manager*:&nbsp;<input type="text" name="manager" style="width:300px;" maxlength="100">&nbsp;<img src="*path_to_images*/user.png" alt="user" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*www*:&nbsp;<input type="text" name="www" style="width:300px;" maxlength="100">&nbsp;<img src="*path_to_images*/www.png" alt="www" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*mail*:&nbsp;<input type="text" name="mail" style="width:300px;" maxlength="100"></td>
        </tr>        

<!-- Дополнительная переменная 1
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_1*&nbsp;<input type="text" name="reserved_1" style="width:300px;" value="*rezult_reserved_1*" maxlength="100"></td>
        </tr>
-->

<!-- Дополнительная переменная 2
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_2*&nbsp;<input type="text" name="reserved_2" style="width:300px;" value="*rezult_reserved_2*" maxlength="100"></td>
        </tr>
-->

<!-- Дополнительная переменная 3
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_3*&nbsp;<input type="text" name="reserved_3" style="width:300px;" value="*rezult_reserved_3*" maxlength="100"></td>
        </tr>
-->
        <tr>
            <td bgColor="*bgcolor*" align="right">*num_company_page*:&nbsp;<select name="def_find_page" style="width:40px;"><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select></td>
        </tr>
        <tr>
            <td align="right" bgColor="*bgcolor*">
                <input type="submit" name="regbut" value="*search*" border="0">
            </td>
        </tr>
    </table>
</form>