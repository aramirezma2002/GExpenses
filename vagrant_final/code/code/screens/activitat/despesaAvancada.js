let addUserButton = document.querySelector("#addUserBtn");

let despesaAvancadaForm = document.querySelector(".despesaAvancadaForm");

let enviarDespesaAvancadaBtn = document.querySelector("#enviarDespesaAvancadaBtn");

let userArray = [];

let sliderDisplayer = document.querySelector(".sliderDisplayer");

let importTotalDespesaAvancada = document.querySelector("#importDespesaAvancada");

let titolDespesaAvancada = document.querySelector("#titolDespesaAvancada");

let isValue = document.querySelector("#isValue");

let importDespesaAvancada = document.querySelector("#importDespesaAvancada");


const accentsRegex = /[\u00C0-\u024F]/;


function calculateSliderPercentage() {
    let sliders = document.querySelectorAll(".slider");

    let percentages = document.querySelectorAll(".sliderPercentage")

    let sliderCount = sliders.length;

    if (isValue.checked) {
        sliders.forEach(element => {
            element.max = importDespesaAvancada.value;
            element.value = importDespesaAvancada.value / sliderCount;
            percentages.forEach(percentage => {
                percentage.value = element.value;

            });
        });
    } else {

        sliders.forEach(element => {
            element.max = 100
            element.value = 100 / sliderCount;
            percentages.forEach(percentage => {
                percentage.value = element.value;

            });
        });
    }

}

importTotalDespesaAvancada.addEventListener("input", (e) => {
    calculateSliderPercentage();
})

function sliderValuesEquals100() {
    let inputs = document.querySelectorAll(".sliderPercentage");

    let value = 0;

    let equals100 = false;


    inputs.forEach(element => {
        value += parseInt(element.value);
    });

    if (value == importDespesaAvancada.value) {
        equals100 = true;
    }

    return equals100;
}

function sliderPercentageEquals100() {
    let sliders = document.querySelectorAll(".slider");

    let value = 0;

    let equals100 = false;

    sliders.forEach(element => {
        value += parseInt(element.value);
    });

    if (value == 100) {
        equals100 = true;
    }

    return equals100;
}

function checkDespesaAvancadaImputs() {
    let isNull = false;

    let error = document.querySelector(".error");

    if (titolDespesaAvancada.value == "") {
        isNull = true;
        error.innerHTML = "ERROR! El titol no pot estar buit";
        error.classList.add("displayError");
    }
    if (importTotalDespesaAvancada.value == "") {
        isNull = true;
        error.innerHTML = "ERROR! La quantitat no pot estar buida";
        error.classList.add("displayError");
    }

    if (titolDespesaAvancada.value.match(accentsRegex)) {
        isNull = true;

        error.textContent = "ERROR! No poden haver accents."
        error.classList.add("displayError");
    }
    if (importTotalDespesaAvancada.value < 0) {
        isNull = true;
        error.textContent = "ERROR! Els imports no poden ser negatius."
        error.classList.add("displayError");
    }

    if (isValue.checked) {
        if (!sliderValuesEquals100()) {
            isNull = true;
            error.innerHTML = "ERROR! Les quantitats no son correctes!";
            error.classList.add("displayError");
        }
    } else {
        if (!sliderPercentageEquals100()) {
            isNull = true;
            error.innerHTML = "ERROR! Els percentatges no son correctes!";
            error.classList.add("displayError");
        }
    }

    return isNull;
}

function createSlider(nomUsuari) {

    let container = document.createElement("div");

    container.className = "sliderContainer"

    let userLabel = document.createElement("label");
    userLabel.innerHTML = nomUsuari;
    userLabel.className = "userName";

    let slider = document.createElement("input");
    slider.type = "range";
    slider.min = "1";
    slider.max = "100";
    slider.className = "slider";

    let numberInput = document.createElement("input");
    numberInput.type = "nubmber";
    numberInput.className = "sliderPercentage";

    slider.addEventListener('input', function (e) { numberInput.value = e.target.value; });
    numberInput.addEventListener('input', function (e) { slider.value = e.target.value; });

    container.append(userLabel);
    container.append(slider);
    container.append(numberInput);

    return container;
}

addUserButton.addEventListener("click", (e) => {

    let selectedUser = document.querySelector("#userSelector").value;

    if (selectedUser != "none") {
        let usuariExisteix = false;

        for (let index = 0; index < userArray.length; index++) {
            if (selectedUser == [userArray[index]]) {
                usuariExisteix = true;
            }
        }

        if (!usuariExisteix) {
            userArray.push(selectedUser);

            sliderDisplayer.append(createSlider(selectedUser));
            calculateSliderPercentage();
        }
    }

})

enviarDespesaAvancadaBtn.addEventListener("click", (e) => {
    e.preventDefault();

    if (!checkDespesaAvancadaImputs()) {

        userArray = [];

        //Todas las labels con los nombres de los usuarios.
        let labelUserName = sliderDisplayer.querySelectorAll(".userName");
        //Todos los porcentajes de cada usuario.
        let percentagePerUsuari = sliderDisplayer.querySelectorAll(".slider");
        //Import

        for (let index = 0; index < labelUserName.length; index++) {
            let inputNames = document.createElement("input");
            inputNames.hidden = true;
            inputNames.name = "userNames[]";
            inputNames.value = labelUserName[index].innerHTML

            let inputPercentage = document.createElement("input");
            inputPercentage.hidden = true;
            inputPercentage.name = "imports[]";
            if (isValue.checked) {
                inputPercentage.value = percentagePerUsuari[index].value;
            } else {
                inputPercentage.value = (percentagePerUsuari[index].value * importTotalDespesaAvancada.value) / 100;
            }

            sliderDisplayer.append(inputNames);
            sliderDisplayer.append(inputPercentage);
        }
        despesaAvancadaForm.submit();
    }
})

isValue.addEventListener("click", (e) => {
    calculateSliderPercentage();
})
