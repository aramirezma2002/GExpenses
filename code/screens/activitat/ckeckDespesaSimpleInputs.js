const accentsRegex = /[\u00C0-\u024F]/;

let despesaSimpleName = document.querySelector("#titolDespesaSimple");

let despesaSimpleImport = document.querySelector("#importDespesaSimple");

let despesaSimpleForm = document.querySelector(".despesaSimpleForm");

let despesaSimpleSelect = document.querySelector("#despesaSimpleSelect");

despesaSimpleForm.addEventListener("submit", (e) => {
    e.preventDefault();

    let despesaSimpleError = despesaSimpleForm.querySelector(".error");

    if (despesaSimpleName.value.match(accentsRegex)) {
        despesaSimpleError.textContent = "ERROR! No poden haver accents."
        despesaSimpleError.classList.add("displayError");
    } else if (despesaSimpleImport.value < 0) {
        despesaSimpleError.textContent = "ERROR! Els imports no poden ser negatius."
        despesaSimpleError.classList.add("displayError");
    } else if (despesaSimpleName.value == "" || despesaSimpleImport.value == "") {
        despesaSimpleError.textContent = "ERROR! No poden haver camps buits."
        despesaSimpleError.classList.add("displayError");
    } else if (despesaSimpleSelect.value == "none") {
        despesaSimpleError.textContent = "ERROR! Has de seleccionar la persona que paga."
        despesaSimpleError.classList.add("displayError");
    } else {
        despesaSimpleForm.submit();
    }

})