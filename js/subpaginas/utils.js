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
function showDiv(idDiv){
	$('#'+idDiv).removeClass('oculta').addClass('visible');
}
function hideDiv(idDiv){
	$('#'+idDiv).removeClass('visible').addClass('oculta');
}