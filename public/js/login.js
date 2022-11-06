
const signUpButton = document.getElementById('signUp');
if(signUpButton){
	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
}

const signInButton = document.getElementById('signIn');
if(signInButton) {
	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
}
const container = document.getElementById('container');
