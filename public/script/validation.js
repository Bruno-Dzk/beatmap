const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const repeatedPasswordInput  = document.querySelector("#repeated_password");

var repeatedPasswdTimeout = null;

function passwordsMatch(password, repeatedPassword) {
    return password === repeatedPassword;
}

repeatedPasswordInput.addEventListener("input", function(){
    if(repeatedPasswdTimeout){
        clearTimeout(repeatedPasswdTimeout);
    }
    repeatedPasswdTimeout = setTimeout( ()=> {
        if(!passwordsMatch(
            passwordInput.value,
            repeatedPasswordInput.value
        )){
            passwordInput.classList.add("invalid");
            repeatedPasswordInput.classList.add("invalid");
            console.log("Passwords do not match");
        }
    }, 1000);
})