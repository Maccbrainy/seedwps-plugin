require('vanilla-tilt');

document.addEventListener('DOMContentLoaded', function(e) {
	
	VanillaTilt.init(document.querySelectorAll(".portfolio-data-content"), {
		max: 5,
		speed: 50,
		gyroscopeMinAngleX: -10,
		gyroscopeMaxAngleX: 10,
		gyroscopeMinAngleY:-10,
		gyroscopeMaxAngleY:10
	});

});

