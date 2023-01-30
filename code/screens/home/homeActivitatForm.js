let formularioActivitat = `
<div class="modal">
<div class="modal-container">
    <div class="modal-header">
        <h2 class="titol">Nueva actividad</h2>
    </div>

    <div class="modal-margin">
        <form class="modal-form" method="POST" id="form-act" name="form_act">
            <p class="error"></p>
            <p><input type="text" placeholder="Nombre actividad" name="act_nom"></p>
            
            <p>
                <select id="moneda" name="Moneda" form="form-act">
                    <option value="def">Tipo de moneda</option>
                    <option value="USD">$</option>
                    <option value="EUR">€</option>
                </select>
            </p>

            <div class="btns">
                <p><input id="btn-cerrar-popUp" type="button" value="Cancelar"></p>
                <p><input type="submit" id="btn-crear" value="Crear"></p>
            </div>
        </form>
    </div>

</div>
</div>`;

const btnAbrirPopUp = document.querySelector("#btn-abrir-popUp");
const paramDiv = document.querySelector(".paramDiv");

let btnCerrarPopUp = "";
let modal = "";
let formularioCreado = false;

const accentsRegex = /[\u00C0-\u024F]/;

btnAbrirPopUp.addEventListener("click",(e)=>{
    e.preventDefault();

    if(formularioCreado == true){
        modal.classList.add('modal-show');
    }else{
        paramDiv.insertAdjacentHTML("beforeend",formularioActivitat);
        modal = document.querySelector(".modal");
        modal.classList.add('modal-show');
        btnCerrarPopUp = document.querySelector("#btn-cerrar-popUp");
        formularioCreado = true;

        btnCerrarPopUp.addEventListener("click",(e)=>{
            e.preventDefault();
            modal.classList.remove('modal-show');
            formAct.elements.act_nom.value = "";
            formAct.elements.Moneda.value = "def";
        });

        const formAct = document.getElementById("form-act");

        formAct.addEventListener("submit", (e)=>{
            e.preventDefault();
    
            const inputTitol = formAct.elements.act_nom.value;
            const inputMoneda = formAct.elements.Moneda.value;
            let error = document.querySelector(".error");

            if(inputTitol == "" || inputMoneda == "" ){
                error.textContent = "ERROR! No hi poden haver dades buides";
                error.classList.add("displayError");
            }else if(inputTitol.match(accentsRegex)){
                error.textContent = "ERROR! No hi poden haver accents";
                error.classList.add("displayError");
            }else if(inputMoneda == "def"){
                error.textContent = "ERROR! Selecciona un tipus de moneda";
                error.classList.add("displayError");
            }else{
                modal.classList.remove('modal-show');
                formAct.submit();
                formAct.elements.act_nom.value = "";
                formAct.elements.Moneda.value = "";
            }
        });
    }

});
