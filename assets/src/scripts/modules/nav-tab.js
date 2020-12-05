window.addEventListener('load', function(){

	PR.prettyPrint();

	
	//store tabs variables
	var tabs = document.querySelectorAll('ul.nav-tabs > li'); //[li.active, li, li]

	for ( i = 0; i < tabs.length; i++ ){
		tabs[i].addEventListener('click', switchTab);
	}

	function switchTab(event){
		event.preventDefault();
		
		document.querySelector('ul.nav-tabs li.active').classList.remove('active');
		document.querySelector('.tab-pane.active').classList.remove('active');

		var clickedTab = event.currentTarget; //<li class="active">...</li>
		var anchor = event.target; //<a href="...">...</a>
		var activePanelID = anchor.getAttribute('href'); //#tab-...
		clickedTab.classList.add('active');
		document.querySelector(activePanelID).classList.add('active');
		
	}
});