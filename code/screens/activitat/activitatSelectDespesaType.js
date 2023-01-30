//Obrir i tancar popup de seleccio de despesa

const btnObrirDespesaSelector = document.querySelectorAll("#btnAfegirDespesa");
const btnTancarPopUpDespesa = document.querySelectorAll(".btn-cerrar-popUp-selectDespesaType")

const labelDespesa = document.querySelectorAll(".cardInfoTitle label");

const despesaSelector = document.querySelectorAll(".despesaSelector");

const id = document.querySelectorAll(".hiddenLabelSelector");

for (let i = 0; i < btnObrirDespesaSelector.length; i++) {
    btnObrirDespesaSelector[i].addEventListener("click", function () {
        despesaSelector[0].classList.add("invitacion-show");
        for (let j = 0; j < labelDespesa.length; j++) {
            if (i == j) {
                const nomActivitatDespesa = labelDespesa[j].innerHTML;
                nomActivitatDespesa.replace
                localStorage.setItem("currentTitle", nomActivitatDespesa);
                localStorage.setItem("currentId", id[j].id);
                document.cookie = "currentIdActivitat=" + id[j].id;
            }
        }
    });
}

for (let i = 0; i < btnTancarPopUpDespesa.length; i++) {
    btnTancarPopUpDespesa[i].addEventListener("click", function () {
        despesaSelector[i].classList.remove("invitacion-show");
    });
}


const despesaSimple = document.querySelector("#simple");

despesaSimple.addEventListener("click", (e) => {
    let form = document.createElement("form");
    form.method = "POST";
    form.className = "formform";

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "simpleForm";
    input.value = "simpleForm";

    let inputId = document.createElement("input");
    inputId.type = "hidden";
    inputId.name = "currentId";
    inputId.value = localStorage.getItem("currentId");

    form.appendChild(input);
    form.appendChild(inputId);

    despesaSimple.append(form);

    let simpleForm = document.querySelector(".formform");
    simpleForm.submit();
    simpleForm.remove();
})

const despesaAvancada = document.querySelector("#avancada");

despesaAvancada.addEventListener("click", (e) => {
    let form = document.createElement("form");
    form.method = "POST";
    form.className = "advancedform";

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "advancedForm";
    input.value = "advancedForm";

    let inputId = document.createElement("input");
    inputId.type = "hidden";
    inputId.name = "currentId";
    inputId.value = localStorage.getItem("currentId");

    form.appendChild(input);
    form.appendChild(inputId);

    despesaSimple.append(form);

    let advancedForm = document.querySelector(".advancedform");
    advancedForm.submit();
    advancedForm.remove();
})