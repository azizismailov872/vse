let lockPaddingValue = window.innerWidth - document.querySelector('.wrap').offsetWidth + 'px';

document.onkeyup = function (e) {
    e = e || window.event;

    if (e.keyCode === 13) {
    	$('#create-order-form').submit();
    }

    // Отменяем действие браузера

    return false;
}

$(document).ready(function(){


    
    //Исчезновение алерта
    let alertSuccess = $('#success-alert');

    let alertError = $('#error-alert');

    if(alertSuccess.length > 0 || alertError.length > 0)
    {
        setTimeout(function(){
            $.pjax.reload({container: '#alerts'});
        },2500)
    }
   	
   	$('.categories-link').click(function(){

   		setTimeout(function(){
	   		$('.sidebar').removeClass('open');
			$('.sidebar-wrap').removeClass('open');
			$('.burger-btn').removeClass('active');
			if($('body').hasClass('lock'))
			{
				$('body').removeClass('lock');
			}
   		},500);
   	});

   	$('.sidebar-menu-link').click(function(){

   		setTimeout(function(){
	   		$('.sidebar').removeClass('open');
			$('.sidebar-wrap').removeClass('open');
			$('.burger-btn').removeClass('active');
			if($('body').hasClass('lock'))
			{
				$('body').removeClass('lock');
			}
   		},500);
   	});
	
	/*Закрытие сайдбара*/
	$('.sidebar-wrap').click(function(){
		$('.sidebar').removeClass('open');
		$('.sidebar-wrap').removeClass('open');
		$('.burger-btn').removeClass('active');
		if($('body').hasClass('lock'))
		{
			$('body').removeClass('lock');
		}
	});

	//Добавление маски
	$('.mask').inputmask({
        mask: "+\\9\\9\\6(999)999-999"
       
    });
	
    //Кнопка вверх
    $('#up-to-top').click(function() {
        $('body,html').animate({ scrollTop: 0 }, 700);
    });

    //Cкролл
    $(window).scroll(function() {
        if ($(this).scrollTop() > 80) {
            $('#up-to-top').addClass('active');
        } else{
            $('#up-to-top').removeClass('active');
        }
    });
    
    //Удаление фото профиля
    $('.delete-photo-btn').click(function(){
            id = $(this).attr('id');

            data = {id:id};

            url = '/profile/delete-image';

            grid_id = '#user-photo'
            make_action(url,data,grid_id);
    });

    $('#no-active').click(function(){
    	openPopup($('.popup.no-active'));

    	setTimeout(function(){
    		closePopup($('.popup.no-active'));
    	},5000)
    });

    //Вывод колличество загруженных фото
    fileCount();

    //Popup
    $('.popup-open').click(function(e)
	{	
		e.preventDefault();

		let popupClass = '.' + $(this).attr('id');

		let popup = $(popupClass);

		openPopup(popup);
	});

	$('.popup-close').click(function(){

		let currentPopup = $(this).closest('.popup.open');

		closePopup(currentPopup);

		if($('body').hasClass('lock'))
		{
			$('body').removeClass('lock');
		}

	});

	$('.popup').click(function(e) {
		if ($(e.target).closest('.popup-content').length == 0) {

			closePopup($(this));		
		}
	});

	//order
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

	//message
	$('#write-message-form').on('beforeSubmit',function(){

		let url = '/message/send';

		let data = $(this).serialize();

		sendMessage(url,data);

		return false;
	});

});

//message
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

//Открытие заказа
function openOrder(order)
{
	let id = $(order).attr('id');

	let url = '/order/view/' + id;

	window.location.href = url;
}
//Открытие заказа конец

//Открытие сообщения
function openMessage(message)
{
	let id = $(message).attr('id');

	let url = '/profile/message/' + id;

	window.location.href = url;
}
//Открытие сообщения конец


/*Октрытие сайдбара*/
function activeBurgerMenu(burger)
{
	$(burger).toggleClass('active');

	$('.sidebar').toggleClass('open');

	$('.sidebar-wrap').toggleClass('open');

	$('body').toggleClass('lock');
}
/*Октрытие сайдбара конец*/


//Добавление padding
function lockPadding(paddingValue)
{
	$('.main').css('padding-right',paddingValue);
	$('.header').css('padding-right',paddingValue);
	$('.category').css('padding-right',paddingValue);

	$('body').addClass('lock');
}
//Добавление padding конец

//Функция по открытию padding
function unlockPadding()
{
	$('.main').css('padding-right',0);
	$('.header').css('padding-right',0);
	$('.category').css('padding-right',0);

	$('body').removeClass('lock');
	
}
//Функция по открытию padding конец

//Функция закрытия сайдбара
function closeSidebar()
{
	$('.sidebar').removeClass('open');
	$('.sidebar-wrap').removeClass('open');
	$('.burger-btn').removeClass('active');
	$('body').removeClass('lock');
}
//Функция закрытия сайдбара конец

//Функция действия
function make_action(url,data,grid_id)
{
    if(data !== null)
    {   
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(res)
            {
                if(grid_id !== null)
                {   
                    $.pjax.defaults.timeout = 3000;

                    $.pjax.reload({container: grid_id});

                    if(res !== null)
                    {
                        console.log(res.msg);
                    }
                }
                else
                {   
                    if(res !== null)
                    {
                        console.log(res.msg);
                    }
                }
            },
            error: function (res){
                console.log(res.msg);
            }
        });
    }
}
//Функция действия конец

//Функция колличества загруженных файлов
function fileCount()
{
    let inputs = document.querySelectorAll('.input__file');

    Array.prototype.forEach.call(inputs, function (input) {
        let label = $(input).siblings('.button');

        let labelVal = label.innerText;


        input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
 
        if (countFiles)

          $(label).text(function(index){
            return  'Выбрано файлов: ' + countFiles;
          })
        else
             $(label).text(function(index){
                return labelVal;
              })
        });
    });
}
//Функция колличества загруженных файлов конец


//Функция снятия оплаты
function takePayment(button)
{
	let id = $(button).closest('.order').attr('id');

	$.ajax({
		url: '/order/pay',
		data: {id: id},
		type: 'POST',
		dataType: 'json',
		success: function(res)
		{
			if(res)
			{
				console.log(res);
			}
		},
		error: function(res)
		{
			if(res){
				console.log(res);
			}
		}
	});
}
//Функция снятия оплаты конец

//Popuo
function openPopup(popup)
{	
	let activePopup = $('.popup.open');

	if(activePopup)
	{
		closePopup(activePopup);
	}

	if(popup)
	{
		lockPadding(lockPaddingValue);

		$(popup).addClass('open');

		$(popup).fadeIn('fast');
	}

}


function closePopup(popup)
{
	if(popup.length > 0)
	{
		for(let i = 0; i < popup.length; i++)
		{	
			$(popup[i]).fadeOut('fast');

			setTimeout(function(){
				$(popup[i]).removeClass('open');
			},500);
		}

		unlockPadding();
	}
}

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
				},4000);

				$('#create-order-form textarea').val("");

				$('#create-order-form select').val("");

				$('#orders-list').on('pjax:end',function(event){
		           let order = $(event.target).find('.order');

		            if (order.length > 0) {
		                for (let i = 0; i <= 1; i++) {
		                    $(order[0]).addClass('new');
		                    
		                    setTimeout(function(){
		                        $(order[0]).removeClass('new');
		                    },4500);
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








