document.addEventListener('DOMContentLoaded', function(e) {
	
//Global variables
	const active = {
		navSlide: null,
		mainSlide: null,
		dotSlide: null
	};

	const nextSlide = {
		navSlide: null,
		mainSlide: null,
		dotSlide: null
	};


	const prevButton = document.querySelector('.carousel__button--left');

	const nextButton = document.querySelector('.carousel__button--right');



	const navSlides = [...document.querySelectorAll('.carousel__logo__indicator')];

	const trackSlides = document.querySelectorAll('.carousel__slide');

	// const mainSlides = Array.from(trackSlides);
	//OR
	const mainSlides = [...trackSlides];


	const dotSlides = [...document.querySelectorAll('.carousel_indicator')];

	//Sliding Function
	initSlider();

	

	//Event Listeners
	nextButton.addEventListener('click', () => {
		moveSlides(true);
	});

	prevButton.addEventListener('click', () => {
		moveSlides(false);
	});

	jumpToSlide(navSlides);
	jumpToSlide(dotSlides);



	function initSlider(){
		/**
		 * Add active class to the first slide
		 */
		navSlides[0].classList.add('is-active');
		mainSlides[0].classList.add('is-active');
		dotSlides[0].classList.add('is-active');
	}


	function moveSlides(forward) {
		// console.log(forward);
		/**
         * Moving forward:
         * get the active slide/nav/dot
         * get the indexes of these active slide/nav/dot
         * remove active class from it
         * get the next slide
         * add active class to it
         * if we reach end of the road, get the first slide and make it new active
         * 
         * 
         * Moving Backward
         * get the active slide
         * remove active class from it
         * get the previous slide
         * add active class to it
         * if we reach start, get the last slide and make it new active
         */
        
        //active slide/nav/dot
        active.navSlide = document.querySelector('.carousel__logo__indicator.is-active');

        active.mainSlide = document.querySelector('.carousel__slide.is-active');
        
        active.dotSlide = document.querySelector('.carousel_indicator.is-active');



        //indexes of these active slide/nav/dot
        const activeNav = navSlides.indexOf(active.navSlide);
        

        const activeSlide = mainSlides.indexOf(active.mainSlide);
        

        const activeDot = dotSlides.indexOf(active.dotSlide);
        

        if (forward) {
        	nextSlide.navSlide = navSlides[(activeNav + 1) % navSlides.length];
        	active.navSlide.classList.remove('is-active');
        	nextSlide.navSlide.classList.add('is-active');



        	nextSlide.mainSlide = mainSlides[(activeSlide + 1) % mainSlides.length];
        	active.mainSlide.classList.remove('is-active');
        	nextSlide.mainSlide.classList.add('is-active');


        	nextSlide.dotSlide = dotSlides[(activeDot + 1) % dotSlides.length];
        	active.dotSlide.classList.remove('is-active');
        	nextSlide.dotSlide.classList.add('is-active');
        }else{
        	nextSlide.navSlide = navSlides[((activeNav - 1) + navSlides.length) % navSlides.length];
        	active.navSlide.classList.remove('is-active');
        	nextSlide.navSlide.classList.add('is-active');



        	nextSlide.mainSlide = mainSlides[((activeSlide - 1) + mainSlides.length) % mainSlides.length];
        	active.mainSlide.classList.remove('is-active');
        	nextSlide.mainSlide.classList.add('is-active');


        	nextSlide.dotSlide = dotSlides[((activeDot - 1) + dotSlides.length) % dotSlides.length];
        	active.dotSlide.classList.remove('is-active');
        	nextSlide.dotSlide.classList.add('is-active');
        }
	}

	function jumpToSlide(slides){
		slides.forEach((slide, index)=>{
			slide.addEventListener('click', () => {
				active.navSlide = document.querySelector('.carousel__logo__indicator.is-active');

		        active.mainSlide = document.querySelector('.carousel__slide.is-active');
		        
		        active.dotSlide = document.querySelector('.carousel_indicator.is-active');

		       if (!slide.classList.contains('is-active')) {

		       		active.navSlide.classList.remove('is-active');
					active.mainSlide.classList.remove('is-active');
					active.dotSlide.classList.remove('is-active');

					navSlides[index].classList.add('is-active');
					mainSlides[index].classList.add('is-active');
					dotSlides[index].classList.add('is-active');
		       }
			})
		})
	}

});

