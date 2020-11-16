let lockPaddingValue = window.innerWidth - document.querySelector('.wrap').offsetWidth + 'px';

$(document).ready(function(){
    
    //Исчезновение алерта
    let alertSuccess = $('#success-alert');

    let alertError = $('#error-alert');

    if(alertSuccess.length > 0 || alertError.length > 0)
    {
        setTimeout(function(){
            $.pjax.reload({container: '#alerts'});
        },1500)
    }
   	
   	//Закрытие сайдбара при клике на категорию
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

   	//Закрытие сайдбара при клике на категорию
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

    //Автоматическое закрытие попапа "Не активного заказ"
    $('#no-active').click(function(){
    	openPopup($('.popup.no-active'));

    	setTimeout(function(){
    		closePopup($('.popup.no-active'));
    	},5000)
    });

    //Вывод колличество загруженных фото
    fileCount();
});


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










