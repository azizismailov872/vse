$(document).ready(function(){

	$('#write-message-form').on('beforeSubmit',function(){

		let url = '/message/send';

		let data = $(this).serialize();

		sendMessage(url,data);

		return false;
	});
});

function sendMessage(url,data)
{
	$.ajax({
		url: url,
		data: data,
		type: 'POST',
		dataType: 'json',
		success: function(res)
		{	
			console.log(res);
			if(res.result == true)
			{
				let popup = $('.popup.success');

				$('.popup.success .success-header').text(function(index){
					return 'Сообщение успешно отправлено';
				});

				openPopup($(popup));

				setTimeout(function(){
					closePopup($(popup));
				},5000);

				$('#write-message-form textarea').val("");
			}
		},
		error: function(res)
		{
			console.log(res);
		}
	})
}