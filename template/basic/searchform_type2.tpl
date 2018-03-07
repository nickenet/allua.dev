<? /*

Шаблон формы поиска тип 2

*/ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
 <tr>
  <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

	<script type="text/javascript">
	function startSearch()
	{
		var sForm = document.getElementById('search_form');
		if (!sForm)
		{
			return;
		}

		sForm.setAttribute('action', this.getAttribute('value'));
	}


	function initSearch()
	{
		var sForm = document.getElementById('search_form');
		if (!sForm)
		{
			return;
		}

		var chList = sForm.getElementsByTagName('input');
		var elm;
		for (var i = 0; i < chList.length; ++i)
		{
			elm = chList[i];
			if (elm.getAttribute('type') == 'radio')
			{
				elm.onclick = startSearch;
			}

			if (elm.getAttribute('checked'))
			{
				sForm.setAttribute('action', elm.getAttribute('value'));
			}
		}
	}
	</script>

<form action="" method="post" id="search_form">
	<table width="100%" border="0" cellspacing="3" cellpadding="4">
		<tr>
			<td width="90%">
				<input type="text" name="skey" id="autocomplete" maxlength="60" style="width:100%; height:22px; font-size:16px;">
			</td>
			<td width="10%" align="center">
				<input type="submit" value="*button_search*" style="width:150px; height:22px;">
			</td>
		</tr>
	<tr>
		<td colspan="2" class="searchik">
			<label><input type="radio" style="background:none; border: 0px;" name="search_type" value="*dir_to_main*/search-1.php" checked="checked">*text_find_company*</label>
			<label><input type="radio" style="background:none; border: 0px;" name="search_type" value="*dir_to_main*/search-2.php">*text_find_product*</label>
			<label><input type="radio" style="background:none; border: 0px;" name="search_type" value="*dir_to_main*/search-5.php">*text_find_pub*</label>
			<label><input type="radio" style="background:none; border: 0px;" name="search_type" value="*dir_to_main*/search-6.php">*text_find_price*</label>
			<label><input type="radio" style="background:none; border: 0px;" name="search_type" value="*dir_to_main*/search-4.php">*text_find_images*</label>
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
initSearch();
</script>

  </td>
 </tr>
</table>