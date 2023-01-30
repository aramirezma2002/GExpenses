const btnSelectDespesa = document.querySelectorAll(".despesa");

const formDespesa = document.querySelectorAll(".formDespesaSelect");

for (let i = 0; i < btnSelectDespesa.length; i++) {
    btnSelectDespesa[i].addEventListener("click", function(e){
        e.preventDefault();
        for (let j = 0; j < formDespesa.length; j++) {
            if (i == j) {

                formDespesa[j].submit();
            }  
        }
    });
    
}