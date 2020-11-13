$(document).ready(function(){

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
});



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


