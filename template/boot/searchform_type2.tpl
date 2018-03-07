<? /*

Шаблон формы поиска тип 2

*/ ?>

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

		<div class="form-group has-warning"><input type="text" class="form-control" name="skey" id="autocomplete" maxlength="60" style="width:100%;" placeholder="Что будем искать?"></div>
		<div class="form-group"><input class="btn btn-danger" type="submit" value="Поиск по каталогу">

                    <div class="btn-group">
			<label class="btn btn-default hidden-xs"><input type="radio" name="search_type" value="*dir_to_main*/search-1.php" checked="checked">*text_find_company*</label>
			<label class="btn btn-default"><input type="radio" name="search_type" value="*dir_to_main*/search-2.php">*text_find_product*</label>
			<label class="btn btn-default hidden-xs"><input type="radio" name="search_type" value="*dir_to_main*/search-5.php">*text_find_pub*</label>
			<label class="btn btn-default hidden-xs"><input type="radio" name="search_type" value="*dir_to_main*/search-6.php">*text_find_price*</label>
			<label class="btn btn-default hidden-xs"><input type="radio" name="search_type" value="*dir_to_main*/search-4.php">*text_find_images*</label>
                    </div>
                    <span style="padding-left: 10px;" class="hidden-xs"><span class="glyphicon glyphicon-search"></span> <a href="./search.php">Расширенный поиск</a> 
                    &nbsp;&nbsp;<span class="glyphicon glyphicon-stats"></span> <a href="./ratingtop.php">Рейтинг фирм</a></span>
                </div>

</form>

<script type="text/javascript">
initSearch();
</script>