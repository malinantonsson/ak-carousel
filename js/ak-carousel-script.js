(function(){
	"use strict";

	var $ = window.jQuery;

	var startslide = 0;

	$('.ak-carousel').slick({
	  	slidesToShow: 1,
	  	initialSlide: startslide,
	  	slidesToScroll: 1,
	  	arrows: true,
  		prevArrow: '.ak-carousel__button--prev',
  		nextArrow: '.ak-carousel__button--next',
	  	autoplay: true,
	  	autoplaySpeed: 5000
	});
})();