<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <header>
        <nav>
            <a href="/code/screens/landing/landing.php">
                <img width="40px" src="../../recursos/img/logo-blanco.png" alt="Logo de GExpense" />
            </a>
            <a class="nom">GExpense</a>
            <a href="/code/screens/login/login.php">
                <img width="25px" src="../../recursos/img/usuario.png" alt="Icono usuario" /></a>
        </nav>
    </header>

    <div class="container-principal">
        <div class="container-izquierda">
            <div class="login">
                <div class="titol">
                    GExpense
                </div>

                <h2 class="login-header">Iniciar Sesión</h2>


                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "user") {
                        echo '<h3 class="error displayError">ERROR! Aquest usuari no existeix.</h3>';
                    }
                }?>
                <h3 class="error" hidden></h3>

                <form class="login-container" method="POST">
                    <p><input type="email" placeholder="Correu" name="user_email"></p>
                    <p><input type="password" placeholder="Contrasenya" name="user_pass" id="pass"></p>
                    <p><input type="submit" value="Contiunar"></p>
                </form>
            </div>
            <div class="create-acount">
                <a href="../register/register.php">Crear compte</a>
            </div>
        </div>
        <div class="container-derecha"></div>
    </div>
    <script src="../../scripts/validation_message.js"></script>
</body>

</html>