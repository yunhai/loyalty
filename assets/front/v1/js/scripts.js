$(window).load(function() {
	$("#loader-wrapper").delay(500).fadeOut('slow');
});
$(document).ready(function(){
	$('.home_slider_product').owlCarousel({
		items: 3,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 3],
		itemsDesktopSmall: [979, 3],
		itemsTablet: [768, 3],
		itemsTabletSmall: [400, 2],
		itemsMobile: [319, 1]
	});
	$('.home_slide_blog').owlCarousel({
		items: 4,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});
	$('.home_slide_blog_1').owlCarousel({
		items: 4,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});
	$('.home_slide_blog_2').owlCarousel({
		items: 4,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});
	$('.home_slide_blog_3').owlCarousel({
		items: 4,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});

	$('.customer_cmt').owlCarousel({
		items: 4,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: true,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});

	$('.content-related-product').owlCarousel({
		items: 5,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dot: false,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 5],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});
	$('.owl-list-video').owlCarousel({
		items: 3,
		autoPlay: false,
		lazyLoad: true,
		addClassActive: true,
		dots: false,
		margin: 20,
		navigation: true,
		slideSpeed: 1000,
		paginationSpeed: 1000,
		navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		itemsDesktop: [1199, 3],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsTabletSmall: [600, 2],
		itemsMobile: [375, 1]
	});
	if($(window).width() < 768 ){
		$('.footer-locker h4, .ft-menu h4').click(function(){
			$(this).next().slideToggle();
		})
	}

	/*Menu*/
	var divMenu = $('div#menu-left ul li.active').parent('ul').parent('div').parent('div');
	divMenu.show();
	divMenu.parent('div').addClass('active');
	$('ul#menu-top ul li.active').parent('ul').parent('li').addClass('active');

});

setTimeout(function(){
	$('.product-preview-box').css('visibility','visible');
	$('.loading-img').remove();
},2500);