const btnBalance = document.getElementById("btnAbrirBalance");
const popUpBalance = document.querySelector(".balance");

btnBalance.addEventListener("click", function (e) {
    popUpBalance.classList.add("balance-show");
});

const btnCloseBlance = document.getElementById("btn-close-balance");
const formBalance = document.getElementById("form-act-balance");

btnCloseBlance.addEventListener("click", function (e) {
    popUpBalance.classList.remove("balance-show");
    btnCloseBlance.classList.add("btnNoClick")
    formBalance.submit();
});


const liniasDeutes = document.querySelectorAll(".infoDeutes");

const textoBalance = document.querySelector(".textoBalance");


for (let i = 0; i < liniasDeutes.length; i++) {
    liniasDeutes[i].addEventListener("click",function(e){
        liniasDeutes[i].classList.add("tachado");
        liniasDeutes[i].classList.remove("movimiento");


        var espacio = " ";
        valor =liniasDeutes[i].textContent.split(espacio);
        let inputInvisible = `<input type="text" class="hiddenBalanceSelector" name="valorBalance[]" value="${valor[0]+"-"+valor[5]}"></input>`;
        textoBalance.insertAdjacentHTML("afterend",inputInvisible);
    });
}

function balanceShow(){
    btnBalance.classList.remove("balanceTimer");
}

setTimeout(balanceShow,1000);