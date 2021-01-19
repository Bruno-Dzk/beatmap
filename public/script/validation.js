const form = document.querySelector("#register_form");
const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const repeatedPasswordInput = document.querySelector("#repeated_password");
const messageDiv = document.querySelector("#message");
const validationMessages = document.createElement("div");

messageDiv.append(validationMessages);

var messages = {};

var passwdMismatchTimeout = null;

function updateValidationMessages(){
    validationMessages.innerHTML = "";
    for(message in messages){
        validationMessages.innerHTML += "<p>" + messages[message] + "</p>";
    }
}

function removeValidationMessage(key){
    if(key in messages){
        delete messages[key];
    }
    updateValidationMessages();
}

function passwordsMatch(password, repeatedPassword) {
    return password === repeatedPassword;
}


document.body.addEventListener('input', event => {
    if (event.target !== passwordInput && event.target !== repeatedPasswordInput) {
        return
    }
    if(passwdMismatchTimeout){
        clearTimeout(passwdMismatchTimeout);
    }
    if(!passwordsMatch(passwordInput.value, repeatedPasswordInput.value)){
        passwdMismatchTimeout = setTimeout( ()=> {
            passwordInput.classList.add("invalid");
            repeatedPasswordInput.classList.add("invalid");
            messages["passwdMismatch"] = "Passwords do not match.";
            updateValidationMessages();
        }, 1000);
    }else{
        passwordInput.classList.remove("invalid");
        repeatedPasswordInput.classList.remove("invalid");
        removeValidationMessage("passwdMismatch");
    }
})