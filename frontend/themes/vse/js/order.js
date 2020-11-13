$(document).ready(function(){

	$('#create-order-form').on('afterValidate',function(event,messages,attributes){

		let close = true;
		attributes.map(function(attribute){
			console.log(attribute.name);
			if(attribute.name == 'author_phone')
			{
				close = false;
			}

		});

		$('#create-order-btn').click(function(){
			if(close == true)
			{
				closePopup($('.popup.new-order'));
			}
		});

	});

	$('#create-order-form').on('beforeSubmit',function(){

		let url = '/order/save';

		let data = $(this).serialize();

		let grid = '#orders-list-pjax';

		saveOrder(url,data,grid);
		
		return false;
	});
});


function saveOrder(url,data,grid)
{
	$.ajax({
		url: url,
		data: data,
		type: 'POST',
		dataType: 'json',
		success: function(res)
		{	
			if(res.result == true)
			{
				openPopup($('.popup.success'));

				$.pjax.defaults.timeout = 3000;

				$.pjax.reload({container: grid});

				setTimeout(function(){
					closePopup($('.popup.success'));
				},5000);

				$('#create-order-form textarea').val("");

				$('#create-order-form select').val("");

				$('#orders-list').on('pjax:end',function(event){
		           let order = $(event.target).find('.order');

		            if (order.length > 0) {
		                for (let i = 0; i <= 1; i++) {
		                    $(order[0]).addClass('new');
		                    
		                    setTimeout(function(){
		                        $(order[0]).removeClass('new');
		                    },6000);
		                }
		            }
				});	

			}
			else
			{
				console.log(res.msg);
			}
		},
		error: function(res)
		{
			console.log(res);
		}
	});
}
