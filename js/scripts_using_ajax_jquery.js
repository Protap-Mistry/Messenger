$(document).ready(function()
{	

	fetch_all_users();
	fetch_active_users();

	setInterval(function()
	{
		update_last_activity();
		fetch_all_users();
		fetch_active_users();
		update_chat_history_data();
		fetch_group_chat_history();

	}, 5000); //5000= 5 seconds

	function fetch_all_users()
	{

		var action= 'fetch_all_users';
		
		//$('#all_users_list').html('');
		$.ajax({
				url: "fetch_all_users.php",
				method: "POST",
				data: {action: action},

				success:function(data)
				{
					//console.log(data);
					
					$('#all_users_list').html(data);
				}

			});
	}

	function fetch_active_users()
	{
		var action= 'fetch_active_users';

		$.ajax({
			url: "active_users_list.php",
			method: "POST",
			data: {action: action},

			success:function(data)
			{
				$('#active_users_list').html(data);
			}
		});
	}

	//update_last_activity();

	function update_last_activity()
	{

		$.ajax({
			url: "last_activity.php",
			success:function()
			{
				
			}
		});
	}

	function make_chat_dialog_box(to_user_id, to_user_name)
	{
		var modal_content= '<div id="user_dialog'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y:scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history'+to_user_id+'">';
		
		//fetch message for receivers
		modal_content += fetch_user_chat_history(to_user_id);

		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message'+to_user_id+'" id="chat_message'+to_user_id+'" class="form-control chat_message" placeholder="Type your message here..."></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content += '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-success send_chat">Send</button></div></div>';

		$('#user_model_details').html(modal_content);
	}

	$(document).on('click', '.start_chat', function(){
		var to_user_id= $(this).data('touserid');
		var to_user_name= $(this).data('tousername');

		make_chat_dialog_box(to_user_id, to_user_name);

		$("#user_dialog"+to_user_id).dialog({

			autoOpen:false,
			width:400
		});
		$("#user_dialog"+to_user_id).dialog('open');

		//for emoji
		$('#chat_message'+to_user_id).emojioneArea({

			pickerPosition: "top",
			toneStyle: "bullet"
		});
	});

	$(document).on('click', '.send_chat', function(){
		var to_user_id= $(this).attr('id');
		var chat_message= $('#chat_message'+to_user_id).val();
		var action= 'chat';

		$.ajax({
			url: "chat.php",
			method: "POST",
			data:{to_user_id:to_user_id, chat_message:chat_message, action:action},

			success:function(data)
			{
				$('#chat_message'+to_user_id).val('');

				//for clearing area after sent emoji
				var element= $('#chat_message'+to_user_id).emojioneArea();
				element[0].emojioneArea.setText('');

				$('#chat_history'+to_user_id).html(data);
			}
		});
	});

	function fetch_user_chat_history(to_user_id)
	{
		var action= 'fetch_chat';

		$.ajax({
			url: "chat.php",
			method: "POST",
			data:{to_user_id:to_user_id, action:action},

			success:function(data)
			{
				$('#chat_history'+to_user_id).html(data);
			}
		});
	}

	function update_chat_history_data()
	{
		$('.chat_history').each(function(){
			var to_user_id= $(this).data('touserid');

			fetch_user_chat_history(to_user_id);
		});
	}

	$(document).on('focus', '.chat_message', function(){

		var is_typing= 'yes';
		var action= 'typing';

		$.ajax({
			url: "typing.php",
			method: "POST",
			data: {is_typing:is_typing, action:action},

			success:function()
			{
				
			}
		});
	});

	$(document).on('blur', '.chat_message', function()
	{
		var is_typing= 'no';
		var action= 'typing';

		$.ajax({
			url: "typing.php",
			method: "POST",
			data: {is_typing:is_typing, action:action},

			success:function()
			{
				
			}
		});
	});

	$('#group_chat_dialog').dialog({

		autoOpen:false,
		width:400
	});

	$('#group_chat').click(function(){

		$('#group_chat_dialog').dialog('open');
		$('#is_active_group_chat_window').val('yes');

		//for emoji
		// $('#group_chat_message').emojioneArea({

		// 	pickerPosition: "top",
		// 	toneStyle: "bullet"
		// });

		fetch_group_chat_history();
	});

	$('#send_group_chat').click(function(){

		var group_chat_message= $('#group_chat_message').html();
		var action= 'group_chat';

		if(group_chat_message != '')
		{
			$.ajax({
				url: "group_chat.php",
				method: "POST",
				data: {group_chat_message:group_chat_message, action:action},

				success:function(data)
				{
					$('#group_chat_message').html('');

					// //for clearing area after sent emoji
					// var element= $('#group_chat_message').emojioneArea();
					// element[0].emojioneArea.setText('');

					$('#group_chat_history').html(data);
				}
			});
		}
	});

	function fetch_group_chat_history()
	{
		var group_chat_dialog_active= $('#is_active_group_chat_window').val();
		var action= "fetch_group_chat";

		if(group_chat_dialog_active == "yes")
		{
			$.ajax({
				url: "group_chat.php",
				method: "POST",
				data: {action:action},

				success:function(data)
				{
					$('#group_chat_history').html(data);
				}
			});
		}		
	}

	$('#uploadFile').on('change', function(event){

		var output = document.getElementById('show');
	    output= URL.createObjectURL(event.target.files[0]);

	    output.onload = function() {
	      URL.revokeObjectURL(output) // free memory
	    }
		$('#uploadImage').ajaxSubmit({

   			target: '#group_chat_message',
    		resetForm: true
		 });
	});

	$(document).on('click', '.remove_chat', function(){

		var chat_message_id= $(this).attr('id');
		var action= 'remove_msg';

		if(confirm("Are u sure to remove this message?"))
		{
			$.ajax({
				url: "remove_chat.php",
				method: "POST",
				data:{chat_message_id:chat_message_id, action:action},

				success:function(data)
				{
					update_chat_history_data();
					//fetch_group_chat_history();
				}
			});
		}
	});

	//navbar search to get whole details of users

	$('#navbar_search').typeahead({
		source:function(query_type, result)
		{
			$('.typeahead').css('position', 'absolute');

			var nav_search= 'search_users_to_get_details';

			$.ajax({
				url: "search.php",
				method: "POST",
				data: {query_type:query_type, nav_search:nav_search},
				dataType:"json",

				success:function(data)
				{
					result($.map(data, function(item){
						return item;
					}));
				}
			});
		}
	});

	//to show search result into a page of searching usesr details
	$(document).on('click', '.typeahead li', function(){

		var search_query= $(this).text(); //return text on which one we click
		window.location.href="navbar_search_result.php?data="+search_query;
	});

	$(document).on('click', '.okay', function(){

		var index= $(this).text();
		window.location.href="index.php?data="+index;
	});

	function showRecords(perPageCount, pageNumber) {
        $.ajax({
            method: "GET",
            url: "fetch_all_users.php",
            data: "pageNumber=" + pageNumber,
            cache: false,

            success: function(html) 
            {
                $("#users_pagination").html(html);
            }
        });
    }
    
    showRecords(10, 1);
});