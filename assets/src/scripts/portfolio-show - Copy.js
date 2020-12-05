document.addEventListener('DOMContentLoaded', function(e) {
	//From Alecaddd tutorirals
	//
	// 
	//store tabs variables
	// const tabs = document.querySelectorAll('ul.nav-tabs > li'); //[li.active, li, li]
	// // console.log(tabs);

	// for ( i = 0; i < tabs.length; i++ ){
	// 	tabs[i].addEventListener('click', switchTab);
	// }

	// function switchTab(e) {
	// 	e.preventDefault();

	// 	document.querySelector('ul.nav-tabs li.active').classList.remove('active');
	// 	document.querySelector('.tab-pane.active').classList.remove('active');

	// 	const clickedTab = e.currentTarget; //<li class="active">...</li>
	// 	const anchor = e.target; //<a href="...">...</a>
	// 	// console.log(anchor);
	// 	const activePanelID = anchor.getAttribute('href'); //#tab-...
	// 	clickedTab.classList.add('active');
	// 	document.querySelector(activePanelID).classList.add('active');
	// 	document.querySelector('.tab-pane.active').classList.add('active');
	// }
// });

// const currentcontent = document.querySelector('#currentcontent');
// const img_thumb = document.querySelectorAll('.img-thumb img');

// img_thumb.forEach(img => img.addEventListener('click', (e)=> 
// 	currentcontent.src = e.target.src));



//Global variables
const sliderView = document.querySelector('.ac-slider--view > ul');
const sliderViewSlides = document.querySelectorAll('.ac--views__slides');
const arrowLeft = document.querySelector('.ac-slider--arrows__left');
const arrowRight = document.querySelector('.ac-slider--arrows__right');
const sliderLength = sliderViewSlides.length;

// console.log(sliderViewSlides);

//Sliding function
const slideFunc = (sliderViewItems, isActiveItem) => {// update the classes 
	isActiveItem.classList.remove('is-active');
	sliderViewItems.classList.add('is-active');

	//css transform the active slide position
	sliderView.setAttribute('style', 'transform:translateX(-' + sliderViewItems.offsetLeft + 'px)');
	}
//Before sliding function
const beforeSLiding = i => {
	let isActiveItem = document.querySelector('.ac--views__slides.is-active');

	let currentItem = Array.from(sliderViewSlides).indexOf(isActiveItem) + i;

	let nextItem = currentItem + i;
	let sliderViewItems = document.querySelector(`.ac--views__slides:nth-child(${nextItem})`);

	//if nextItem is bigger than the # of slides
	if(nextItem > sliderLength){
		sliderViewItems = document.querySelector('.ac--views__slides:nth-child(1)');
		}

		// if nextItem is 0
		if(nextItem == 0){
			sliderViewItems = document.querySelector(`.ac--views__slides:nth-child(${sliderLength})`);
		}

		//trigger the sliding method
		slideFunc(sliderViewItems, isActiveItem);

	}

//Triger arrow function
arrowRight.addEventListener('click', () => beforeSLiding(1));

arrowLeft.addEventListener('click', () => beforeSLiding(0));

});