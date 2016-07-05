var slideShown = new Array();
function loadPageFromFragment(){
	switch (window.location.hash) {
		case '#consulting':
		case '#training':
		case '#scala-101':
		case '#scala-101-es':
		case '#scala-101-ed1':
		case '#scala-101-ed1-es':
		case '#functional-101':
		case '#functional-101-es':
		case '#functional-101-ed1':
		case '#functional-101-ed1-es':
		case '#functional-101-ed2':
		case '#functional-101-ed2-es':
		case '#functional-101-ed3':
		case '#functional-101-ed3-es':
		case '#functional-advanced':
		case '#functional-advanced-es':
		case '#functional-advanced-ed1':
		case '#functional-beeva-1':
		case '#functional-singular-1':
		case '#product':
		case '#partners':
		case '#team':
		case '#community':
		case '#contact':
			showPage(window.location.hash.substring(1));
			break;
		default:
			showPage('home');
	}
}
function scrollMeTo(toSelector){
	$('html,body').animate({
		scrollTop: $(toSelector).offset().top
	}, 1000);
	return false;
}
function showPage(idPage){

	if(idPage=='community'){
		if(isTablet() || isPhone()){
			idPage='community-m'
		}
	}
	$('.nav li').removeClass('active');
	$('.nav li.'+idPage).addClass('active');
	$('.subpagina').removeClass('visible').addClass('oculta');
	$('.'+idPage+'.subpagina').removeClass('oculta').addClass('visible');
	$('#navbar').removeClass('visibleEnMovil').addClass('ocultaEnMovil');
	window.location.hash = idPage;
	window.scrollTo(0, 0);
}
function goTo(idGoal){
	/*Scrolls to a div with id=#idGoal*/
	$('html, body').animate({
        scrollTop: $('#'+idGoal).offset().top
    }, 2000);
}
function showDiv(idDiv,slide,img){	
	/*Shows a div width id=#idDiv
	* if slide==true the container of the div is shown with a slide effect*/
	if(slide && !isTablet() && !isPhone()){
		if(slideShown[idDiv]===undefined || slideShown[idDiv]===false){			
			$('#'+idDiv).removeClass('oculta').addClass('visible');
			$('#'+idDiv).parent().slideDown({
				always: function(){ slideShown[idDiv]=true;}
			});
		}
	}else{
		$('#'+idDiv).removeClass('oculta').addClass('visible');
	}
	/*if(img){changeImg(img);}*/
}
function hideDiv(idDiv,slide,img){
	/*Hides a div width id=#idDiv
	* if slide==true the container of the div is hidden with a slide effect*/
	if(slide && !isTablet() && !isPhone()){
		if(slideShown[idDiv]===true){
			$('#'+idDiv).parent().slideUp({
				always: function(){ 
					slideShown[idDiv]=false;
					$('#'+idDiv).removeClass('visible').addClass('oculta');
				}
			});
				
		}	
	}else{
		$('#'+idDiv).removeClass('visible').addClass('oculta');
	}
	/*if(img){changeImg(img);}*/
}
function getScreenWidth(){
	return screen.width;
}
function getDevice(){
	 return navigator.userAgent.toLowerCase();
}
function isTablet(){
	return getDevice().search(/ipad|android/)!=-1 /*&& getScreenWidth()<800 && getScreenWidth()>480*/;
}
function isPhone(){
	return getDevice().search(/iphone|ipod|android/)!=-1 /*&& getScreenWidth()<480*/;
}

function toggleMenu(){
	$('#navbar').hasClass('ocultaEnMovil') ? $('#navbar').removeClass('ocultaEnMovil').addClass('visibleEnMovil') : $('#navbar').removeClass('visibleEnMovil').addClass('ocultaEnMovil');
}
function changeImg(img){
	/*Change images ByN-->Color and vv.*/
	var src=$('#'+img).attr('src');
	src= src.indexOf("ByN")!==-1 ? src.replace("ByN","") : src.replace(".png","")+"ByN.png";
	$('#'+img).attr('src',src)
}
