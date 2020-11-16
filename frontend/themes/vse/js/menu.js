$(function(){
	let pathNameUrl = window.location.pathname;
	let hrefUrl = window.location.href;

	let categories = $('.categories-link');

	for(let i = 0; i < categories.length; i++)
	{
		if(pathNameUrl == $(categories[i]).attr('href'))
		{
			$(categories[i]).addClass('active-menu-link');
			$(categories[i]).siblings('.categories-icon').addClass('active-menu-link');
			$(categories[i]).closest('.categories-item').addClass('active-menu');
		}
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

});