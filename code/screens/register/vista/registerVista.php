<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css" />
    <link rel="stylesheet" href="../styles/global.css" />
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
            <div class="register">

                <h2 class="register-header">Registro</h2>

                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "email") {
                        echo "<p class='error displayError'>ERROR! Aquest email ja está en us.</p>";
                    }

                    if ($_GET["error"] == "user") {
                        echo '<p class="error displayError">ERROR! Aquest username ja está en us.</p>';
                    }

                    if ($_GET["error"] == "remail") {
                        echo '<p class="error displayError">ERROR! Els correus no coincideixen</p>';
                    }

                    if ($_GET["error"] == "rpass") {
                        echo '<p class="error displayError">ERROR! Les contrassenyes no coincideixen</p>';
                    }
                }

                ?>

                <p class="error"></p>

                <form class="register-container" method="POST">
                    <p><input type="text" placeholder="Nom usuari" name="user_userName" id="userUserName" required></p>
                    <p><input type="text" placeholder="Nom" name="user_nombre" id="userName" required></p>
                    <p><input type="text" placeholder="Cognom" name="user_apellido" id="userSurname" required></p>
                    <p><input type="email" placeholder="Correu" name="user_email" id="userEmail" required></p>
                    <p><input type="email" placeholder="Repeteix correu" name="user_rEmail" id="userRemail" required></p>
                    <p><input type="password" placeholder="Contrasenya" name="user_pass" id="pass" required></p>
                    <p><input type="password" placeholder="Repeteix contrasenya" name="user_rPass" id="userRpass" required></p>
                    <p><input type="submit" value="Continuar"></p>
                </form>
                <div class="iniciar-sesion">
                    <a href="../login/login.php" style="text-decoration:none" >Prefereixo iniciar sessió</a>                      
                    </div>
            </div>
        </div>
        <div class="container-derecha"></div>
    </div>
    <script src="../../scripts/validation_message.js"></script>
</body>

</html>