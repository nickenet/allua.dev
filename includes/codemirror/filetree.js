// jQuery File Tree Plugin
//
// 2008 A Beautiful Site, LLC. (http://abeautifulsite.net/blog/2008/03/jquery-file-tree/)
//
//
jQuery&&function(b){b.extend(b.fn,{fileTree:function(a,f){a||(a={});if(a.root==undefined)a.root="/";if(a.script==undefined)a.script="jqueryFileTree.php";if(a.folderEvent==undefined)a.folderEvent="click";if(a.expandSpeed==undefined)a.expandSpeed=500;if(a.collapseSpeed==undefined)a.collapseSpeed=500;if(a.expandEasing==undefined)a.expandEasing=null;if(a.collapseEasing==undefined)a.collapseEasing=null;if(a.multiFolder==undefined)a.multiFolder=true;if(a.loadMessage==undefined)a.loadMessage="Loading...";
b(this).each(function(){function d(c,e){b(c).addClass("wait");b(".jqueryFileTree.start").remove();b.post(a.script,{dir:e},function(g){b(c).find(".start").html("");b(c).removeClass("wait").append(g);a.root==e?b(c).find("UL:hidden").show():b(c).find("UL:hidden").slideDown({duration:a.expandSpeed,easing:a.expandEasing});h(c)})}function h(c){b(c).find("LI A").bind(a.folderEvent,function(){if(b(this).parent().hasClass("directory"))if(b(this).parent().hasClass("collapsed")){if(!a.multiFolder){b(this).parent().parent().find("UL").slideUp({duration:a.collapseSpeed,
easing:a.collapseEasing});b(this).parent().parent().find("LI.directory").removeClass("expanded").addClass("collapsed")}b(this).parent().find("UL").remove();d(b(this).parent(),escape(b(this).attr("rel").match(/.*\//)));b(this).parent().removeClass("collapsed").addClass("expanded")}else{b(this).parent().find("UL").slideUp({duration:a.collapseSpeed,easing:a.collapseEasing});b(this).parent().removeClass("expanded").addClass("collapsed")}else f(b(this).attr("rel"));return false});a.folderEvent.toLowerCase!=
"click"&&b(c).find("LI A").bind("click",function(){return false})}b(this).html('<ul class="jqueryFileTree start"><li class="wait">'+a.loadMessage+"<li></ul>");d(b(this),escape(a.root))})}})}(jQuery);


function RunAjaxJS(insertelement, data)
{
	var milisec = new Date;
	var jsfound = false;
	milisec = milisec.getTime();

	var js_reg = /<script.*?>(.|[\r\n])*?<\/script>/ig;

	var js_str = js_reg.exec(data);
	if (js_str != null) 
	{
		var js_arr = new Array(js_str.shift());
		jsfound = true;

		while(js_str) 
		{
			js_str = js_reg.exec(data);
			if (js_str != null) js_arr.push(js_str.shift());
		}

		for(var i=0; i<js_arr.length;i++) 
		{
			data = data.replace(js_arr[i],'<span id="'+milisec+i+'" style="display:none;"></span>');
		}
	}

	$("#" + insertelement).html(data);

	if (jsfound) 
	{
		var js_content_reg = /<script.*?>((.|[\r\n])*?)<\/script>/ig;

		for (i = 0; i < js_arr.length; i++) 
		{
			var mark_node = document.getElementById(milisec+''+i);
			var mark_parent_node = mark_node.parentNode;
			mark_parent_node.removeChild(mark_node);

			js_content_reg.lastIndex = 0;
			var js_content = js_content_reg.exec(js_arr[i]);
			var script_node = mark_parent_node.appendChild(document.createElement('script'));
			script_node.text = js_content[1];

			var script_params_str = js_arr[i].substring(js_arr[i].indexOf(' ',0),js_arr[i].indexOf('>',0));
			var params_arr = script_params_str.split(' ');

			if (params_arr.length > 1) 
			{
				for (var j=0;j< params_arr.length; j++ ) 
				{
					if(params_arr[j].length > 0)
					{
						var param_arr = params_arr[j].split('=');
						param_arr[1] = param_arr[1].substr(1,(param_arr[1].length-2));
						script_node.setAttribute(param_arr[0],param_arr[1]);
					}
				}
			}
		}
	}
}