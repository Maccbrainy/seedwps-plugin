// require('vanilla-tilt');

// document.addEventListener('DOMContentLoaded', function(e) {
	
// 	VanillaTilt.init(document.querySelectorAll(".portfolio-data-content"), {
// 		max: 5,
// 		speed: 50,
// 		gyroscopeMinAngleX: -10,
// 		gyroscopeMaxAngleX: 10,
// 		gyroscopeMinAngleY:-10,
// 		gyroscopeMaxAngleY:10
// 	});

// });
/*--------------------------------------------------------------
# Require globally jquery library  from the package.json file
--------------------------------------------------------------*/
require("jquery");

$(document).ready(function(){

	$('.portfolio-filter-list').click(function(){
		const value = $(this).attr('data-filter');

		if (value == 'all'){
			$('.portfolio--filter_data').show('1000');
		}else{
			$('.portfolio--filter_data').not('.'+value).hide('1000');
			$('.portfolio--filter_data').filter('.'+value).show('1000');
		}
	})

	//Add active class on selected item
	$('.portfolio-filter-list').click(function(){
		$(this).addClass('is-active').siblings().removeClass('is-active');
	})
});


 