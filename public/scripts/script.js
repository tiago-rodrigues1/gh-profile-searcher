const usernameInput = document.getElementById("username");
const submitButton = document.getElementById("submitbtn");

submitButton.disabled = true;

usernameInput.addEventListener("change", (event) => {
	let { value } = event.target;

	if (String(value).length !== 0) {
		submitButton.disabled = false;
	} else {
		submitButton.disabled = true;
	}
});
