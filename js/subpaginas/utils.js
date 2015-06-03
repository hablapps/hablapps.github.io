var slideShown = new Array();
function showPage(idPage){
	$('.subpagina').removeClass('visible').addClass('oculta');
	$('#'+idPage).removeClass('oculta').addClass('visible');
}
function goTo(idGoal){
	/*Scrolls to a div with id=#idGoal*/
	$('html, body').animate({
        scrollTop: $('#'+idGoal).offset().top
    }, 2000);
}
function showDiv(idDiv,slide){	
	/*Shows a div width id=#idDiv
	* if slide==true the container of the div is shown with a slide effect*/
	if(slide){
		if(slideShown[idDiv]===undefined || slideShown[idDiv]===false){
			slideShown[idDiv]=true;
			$('#'+idDiv).removeClass('oculta').addClass('visible');
			$('#'+idDiv).parent().slideDown();
		}
	}else{
		$('#'+idDiv).removeClass('oculta').addClass('visible');
	}
}
function hideDiv(idDiv,slide){
	/*Hides a div width id=#idDiv
	* if slide==true the container of the div is hidden with a slide effect*/
	if(slide){
		if(slideShown[idDiv]===true){
			slideShown[idDiv]=false;
			$('#'+idDiv).parent().slideUp();
			$('#'+idDiv).removeClass('visible').addClass('oculta');	
		}	
	}else{
		$('#'+idDiv).removeClass('visible').addClass('oculta');
	}
}
