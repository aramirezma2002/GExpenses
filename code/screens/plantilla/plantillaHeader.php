<?php

$usrSession = $_SESSION['user_userName'];


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login/login.php");
}

include("../../connections/connection.php");

if ($pdo != null) {

    try {
        $stmtinsertActivitat = $pdo->query("SELECT username FROM usuari WHERE correu LIKE '$usrSession'");
    } catch (PDOException $ex) {
        echo "Error de PDO" . $ex;
    }
}
?>




<link rel="stylesheet" href="/code/screens/plantilla/plantilla.css" />

<header>
    <nav>
        <div class="leftNavDiv">
            <a href="/code/screens/home/home.php">
                <img class="navImg" width="40px" src="../../recursos/img/logo-blanco.png" alt="Logo de GExpense" />
            </a>
            <!--<a class="nom">GExpense</a>-->
        </div>
        <div class="headerDiv">
            <div>
                <h2>GExpenses</h2>
            </div>
        </div>
        <form method="POST" class="rightNavDiv">
            <label class="headerNomUsuari">
                <?php echo $usrSession ?>
            </label>
            <label for="logout">
                <img width="25px" src="../../recursos/img/icon_exit.png" alt="Icono usuario"/>
                <input type="submit" name="logout" id="logout" hidden>
            </label>
        </form>
    </nav>
</header>