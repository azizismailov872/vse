$(function(){

	//Текущий Url
	let pathNameUrl = window.location.pathname;

	//Категории
	let categories = $('.categories-link');

	let menusList = $('.sidebar-menu-link');

	//Цикл по категориям для сверения с текущим URl
	for(let i = 0; i < categories.length; i++)
	{	
		//Если текущий url совпадает с url категории добавить специальный класс
		if(pathNameUrl == $(categories[i]).attr('href'))
		{
			$(categories[i]).addClass('active-menu-link');
			$(categories[i]).siblings('.categories-icon').addClass('active-menu-link');
			$(categories[i]).closest('.categories-item').addClass('active-menu');
		}
		//Если пользователь находится на странице заказа, то сверить текущий url с url загаловка категории
		else
		{	
			if($('a.category-title').attr('href') == $(categories[i]).attr('href'))
			{
				$(categories[i]).addClass('active-menu-link');
				$(categories[i]).siblings('.categories-icon').addClass('active-menu-link');
				$(categories[i]).closest('.categories-item').addClass('active-menu');
			}
			
		}
	}

	//Те же самые действия но для sidebar-menu
	for(let i =0; i < menusList.length; i++)
	{
		if(pathNameUrl == $(menusList[i]).attr('href'))
		{
			$(menusList[i]).addClass('active-menu-link');
			$(menusList[i]).siblings('.sidebar-menu-icon').addClass('active-menu-link');
			$(menusList[i]).closest('.sidebar-menu-item').addClass('active-menu');
		}
	}

});