let estils = `
    <link rel="stylesheet" href="/code/screens/styles/global.css" />
    <link rel="stylesheet" href="/code/screens/register/register.css" />
`;

let formulari = `
<header><nav></nav></header>
<div class="container-principal">
    <div class="container-izquierda">
        <div class="register">

            <h2 class="register-header">Registro</h2>

            <p class="error" hidden></p>

            <form class="register-container" method="POST">
                <p><input type="text" placeholder="Nom usuari" name="user_userName"></p>
                <p><input type="text" placeholder="Nom" name="user_nombre"></p>
                <p><input type="text" placeholder="Cognom" name="user_apellido"></p>
                <p><input type="email" placeholder="Correu" name="user_email"></p>
                <p><input type="email" placeholder="Repeteix correu" name="user_rEmail"></p>
                <p><input type="password" placeholder="Contrasenya" name="user_pass" id="pass"></p>
                <p><input type="password" placeholder="Repeteix contrasenya" name="user_rPass"></p>

                <p><input type="submit" value="Continuar"></p>
            </form>
        </div>
    </div>
    <div class="container-derecha"></div>
</div>
`;

let body = document.querySelector("body");
let head = document.querySelector("head");
head.insertAdjacentHTML("beforeend", estils)
body.insertAdjacentHTML("beforeend", formulari);
