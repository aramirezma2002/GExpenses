const btnInvitacion = document.getElementById("btnAfegirMembers");
const invitacion = document.querySelector(".invitacionMembers");
const btnCancelarInvitacion = document.querySelector("#btn-cerrar-invitacion");
const btnEnviarCorreos = document.getElementById("form-act-invitacion");

btnInvitacion.addEventListener("click",function(e) {
    e.preventDefault();
    invitacion.classList.add("invitacionMembers-show"); 
});


//creacion del correo li

let li = `
<li class="toggle email-info">
    <input type="text" class="valor-input" name="invitatioMembers[]" value=""></input>
    <text class="info"></text>
    <a class="btn-close"><img width="10px" height="10px" src="../../recursos/img/x.png"></a>
</li>
`;

const btnAfegirCorreo = document.querySelector("#btn-afegir-email");
const input = document.querySelector(".input-textArea");
const llistaCorreo = document.querySelector(".input-text");
let error = document.querySelector(".error");

const verificarCorreo = correo => {
    const test = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]+$/;
    return test.test(correo);
}

function insertCorreo() {

    if (verificarCorreo(input.value) == false) {
        error.innerText = "ERROR! El format del correu no es correcte.";
        error.classList.add("displayError");
        input.value = "";
    } else {
        llistaCorreo.insertAdjacentHTML("beforebegin", li);
        const text = document.querySelectorAll(".info");
        for (let s = 0; s < text.length; s++) {
            if (s === text.length - 1) {
                text[s].innerText = input.value;
            }
        }

        const valor = document.querySelectorAll(".valor-input");
        for (let m = 0; m < valor.length; m++) {
            if (m === valor.length - 1) {
                valor[m].value = input.value;
                input.value = "";
            }
        }

        const btnRemoveEmail = document.querySelectorAll(".btn-close");
        for (let x = 0; x < btnRemoveEmail.length; x++) {
            if (x === btnRemoveEmail.length - 1) {
                btnRemoveEmail[x].addEventListener("click", function () {
                    btnRemoveEmail[x].parentElement.remove();
                });
            }
        }

        error.classList.remove("displayError");
    }
}

btnAfegirCorreo.addEventListener("click", function () {
    insertCorreo();
});

input.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
        e.preventDefault();
        insertCorreo();
    }
});

btnCancelarInvitacion.addEventListener("click", function () {

    invitacion.classList.remove("invitacionMembers-show");

    const correos = document.querySelectorAll(".email-info");
    for (let e = 0; e < correos.length; e++) {
        correos[e].remove();
    }
    
    error.innerText = "";
    error.classList.remove("displayError");
});


btnEnviarCorreos.addEventListener("submit", function (e) {
    e.preventDefault();

    const correos = document.querySelectorAll(".email-info");
    if (correos.length < 1) {
        error.innerText = "ERROR! Afegeix un correu.";
        error.classList.add("displayError");
    } else {
        /* var correos = document.querySelectorAll(".email-info");
            for (let e = 0; e < correos.length; e++) {
                correos[e].remove();
            }*/

        invitacion.classList.remove("invitacionMembers-show");
        btnEnviarCorreos.submit();
    }

});