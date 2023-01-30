const despesa = document.querySelector(".despesaSelect");
despesa.classList.add("despesa-show");

const btnClose = document.querySelector("#btn-close-despesaSelect");

btnClose.addEventListener("click", function(e){
    despesa.classList.remove("despesa-show");
});
