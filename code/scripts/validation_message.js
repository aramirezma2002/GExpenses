const passRegex = /^(?=.*\d)(?=.*[!@#$%^&*?¿=])(?=.*[a-z])(?=.*[A-Z]).{8,}$/

const usernameRegex = /[\u00C0-\u024F]/;

let btn = document.querySelector("form");

btn.addEventListener("submit", (e) => {
    let error = document.querySelector(".error");

    let username = document.getElementById("userUserName").value;

    let email = document.getElementById("userEmail").value;

    let pass = document.getElementById("pass").value;

    let isError = false;

    if (!pass.match(passRegex)) {
        e.preventDefault();
        isError = true;
        error.textContent = "ERROR! La contrasenya ha de tenir 8 caracters, una majuscula, una minuscula y un caracter especial.";
    }

    if (username.match(usernameRegex)) {
        e.preventDefault();
        isError = true;
        error.textContent = "ERROR! No hi poden haver accents.";
    }

    if (email.match(usernameRegex)) {
        e.preventDefault();
        isError = true;
        error.textContent = "ERROR! No hi poden haver accents.";
    }

    if (pass.match(usernameRegex)) {
        e.preventDefault();
        isError = true;
        error.textContent = "ERROR! No hi poden haver accents.";
    }

    if (isError) {
        error.style.display = "block";
    } else {
        error.style.display = "none";
    }
});