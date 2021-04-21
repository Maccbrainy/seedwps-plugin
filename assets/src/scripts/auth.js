document.addEventListener('DOMContentLoaded', function(){
	const showAuthBtn = document.getElementById('seedwps-show-auth-form'),
	authContainer = document.getElementById('seedwps-auth-container'),
	closeBtn = document.getElementById('seedwps-auth-close'),
	loginOverlay = document.querySelector('.site-login-overlay'),

	authForm = document.getElementById('seedwps-auth-form'),
	status = authForm.querySelector('[data-message="status"]');

	 showAuthBtn.addEventListener('click',()=>{
	 	authContainer.classList.add('show');
	 	loginOverlay.classList.add('show');
	 	showAuthBtn.parentElement.classList.add('hide');
	 });

	 closeBtn.addEventListener('click', () => {
	 	authContainer.classList.remove('show');
	 	loginOverlay.classList.remove('show');
	 	showAuthBtn.parentElement.classList.remove('hide');
	 });

	 authForm.addEventListener('submit', e =>{
	 	e.preventDefault();

	 	//Reset the form message
	 	resetMessages();
	 	//Collect all the data from the form
	 	
	 	let data = {
	 		name:authForm.querySelector('[name="username"]').value,
	 		password:authForm.querySelector('[name="password"]').value,
	 		nonce:authForm.querySelector('[name="seedwps_auth"]').value
	 	}

	 	//validation of the form
	 	if (!data.name || !data.password) {
	 		status.innerHTML = "Missing data";
	 		status.classList.add('error');
	 		return;
	 	}

	 	//ajax http post request
	 	let url = authForm.dataset.url;
	 	let params = new URLSearchParams(new FormData(authForm));

	 	authForm.querySelector('[name="submit"]').value = "Logging in...";
	 	authForm.querySelector('[name="submit"]').disable = true;

	 	fetch(url, {
	 		method: "POST",
	 		body: params
	 	}).then(res => res.json())
	 	.catch(error => {
	 		resetMessages();
	 	})
	 	.then(response => {
	 		resetMessages();

	 		if (response===0 || !response.status) {
	 			status.innerHTML = response.message;
	 			status.classList.add('error');
	 			return;
	 		}

	 		status.innerHTML = response.message;
	 		status.classList.add('success');

	 		authForm.reset();


	 		window.location.reload();

	 	})
	 });

	 function resetMessages(){
	 	//reset all the messages
	 	status.innerHTML = "";
	 	status.classList.remove('success', 'error');


	 	authForm.querySelector('[name="submit"]').value = "Login";
	 	authForm.querySelector('[name="submit"]').disable = false;
	 }
});