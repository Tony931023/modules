<span class="get_icon_{$id}">
	<img src="{$url}application/images/armory/default/loading.gif" width="18" height="18"/>
</span>

<script type="text/javascript">
	$(document).ready(function()
	{
		$.get(Config.URL + "icon/get/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".get_icon_" + {$id}).each(function()
	 		{
	 			$(this).html("<img src='/wow-zamimg/static/images/icons/large/" + data + ".jpg' align='absmiddle' width='18px'/>");
	 		});
	 	});
	});
</script>