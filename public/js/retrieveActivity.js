function loadGamertag()
{
	/*
	* Build form for posting with request
	*/
	var $form = $("<form/>");
	var $input = $("<input type='text' name='gamertag' value='ucantsavemenow'>");
	$form.append($input);
	$form = $form.serialize();
	/*
	* Send the gamertag to the server to for validation
	*/
	$.ajax({
    url: $("meta[name=base_url]").attr("content")+"activity",
    type: 'POST',
		headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
    },
    data: $form,
    dataType: 'json',
    success: function (response) {
			console.log(response);
			/*
			var $grid = $('<div class="grid"></div>');
			var ignore = ['created_at', 'id', 'updated_at', 'xuid'];
			for(property in response) {
				if(ignore.indexOf(property) == -1)
				{
					var $grid_item = $('<div class="grid_item"></div>');
					$grid_item.append($('<div>'+property+'</div>'));
					switch(property) {
						case 'game_display_pic_raw':
							$grid_item.append($('<img src='+response[property]+' height="60px" width="60px"/>'));
							break;
						default:
							$grid_item.append($('<div>'+response[property]+'</div>'));
							break;
					}
					$grid.append($grid_item);
				}
			}
			*/
			$("#profile_container").append($grid);
    },
		failure: function(response) {
			console.log("server or request error!");
		}
	});
}
