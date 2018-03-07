<? /*

Шаблон информационной страницы компании для тарифа группы D

*/ ?>

<div style="text-align: center;">*Yandex_map_big*</div>

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

      <div class="row">
           <div class="col-xs-8">
<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"><b><a href="#">Разделы</a></b></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
</div>
               <div class="hidden-xs">*logo*</div>
               <h1 class="companyD">*company*</h1>
               *case*
               <hr>
               <p style="text-align:justify;">*description*</p>
               <hr>

               <div class="panel panel-default">

                   <div class="panel-body">

                        *address*<br>*city* *state* *zip*<br>*country*<br><br>
                        Телефон - *phone*<br />
                        Факс - *fax*<br />
                        Мобильный - *mobile*<br />
                        ICQ - *icq*<br /><br>
                        <span class="glyphicon glyphicon-user"></span> Контактное лицо - <b>*contact*</b><br>
                        *filiallist*

<!--
      Workers: *reserved_1*<br />
      Since *reserved_2*<br />
      Working hours: *reserved_3*<br />
-->

                  </div>
                  
                  <div class="panel-footer">
                      
                      *sxema*<br>
                      <span class="glyphicon glyphicon-map-marker"></span> *map*<br><br>
                      <div class="hidden-xs">*Yandex_map_wym520_hym200*</div><br>
                      *koordinata* *shirota_text**shirota* *dolgota_text**dolgota*<br>
                      
                  </div>

               </div>

               <div>*cats*</div>
               <hr>
               *related_firms*
               
           </div>

            <div class="col-xs-4">
<div class="collapse  infofirm-collapse" id="bs-example-navbar-collapse-1">
                <ul class="list-group">
                    <li class="list-group-item list-group-item list-group-item-info"><span class="glyphicon glyphicon-paperclip"></span> <b>*notepad*</b></li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-calendar"></span> *newslist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-screenshot"></span> *tenderlist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-pushpin"></span> *boardlist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-briefcase"></span> *joblist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-warning-sign"></span> *pressrellist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span> *productslist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-picture"></span> *imageslist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span> *exellist*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-facetime-video"></span> *videolist*</li>
                    <li class="list-group-item  list-group-item-success"><span class="glyphicon glyphicon-envelope"></span> *mail*</li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-globe"></span> *www*</li>
                    <li class="list-group-item  list-group-item-warning"><span class="glyphicon glyphicon-comment"></span> *addreview*</li>
                    <li class="list-group-item">*viewreviews* <div>*rev_good**rev_bad*</div></li>
                    <li class="list-group-item"><span class="glyphicon glyphicon-print"></span> *print*</li>
                    <li class="list-group-item">*friend*</li>
                    <li class="list-group-item"><a href="javascript:ShowOrHide('options','')">Получить код для рейтинга</a>
                        <div id='options' style='display:none;'><textarea name="textarea" cols="32" rows="10">*kodirating*</textarea></div>
                    </li>
                    <li class="list-group-item">*rating*</li>
                    <li class="list-group-item">*rate*</li>
                    <li class="list-group-item" style="text-align:center;">*img_social_link* *twitter* *facebook* *vkontakte* *odnoklassniki*</li>
                    <li class="list-group-item">Метки: *keywords*</li>
                    <li class="list-group-item list-group-item list-group-item-warning"><span class="glyphicon glyphicon-bell"></span> <noindex><a rel="nofollow" href="*link_to_complaint*">*text_to_complaint*</a></noindex></li>
                </ul>
</div>

                <div class="well well-sm hidden-xs" style="text-align: center;">
                    Просмотров всего: *hits*<br>
                    Просмотров за месяц: *hits_m*<br>
                    Просмотров за сегодня: *hits_d*<br>
                </div>
            </div>
      </div>