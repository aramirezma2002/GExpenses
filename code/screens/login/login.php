<?php
session_start();
$email = null;
$pass = null;
if (isset($_POST['user_email'])) {
    $email = htmlentities($_POST['user_email']) . "";
    $pass = htmlentities($_POST['user_pass']) . "";
    $_SESSION['user_email'] = $email;
    $_SESSION['user_pass'] = $pass;

    require "../../connections/connection.php";

    if ($pdo != null) {
        try {
            $stmtUser = $pdo->query("SELECT username, correu, contrasenya FROM usuari WHERE correu LIKE '$email'");

            $user = $stmtUser->fetch();

            if ($user != null) {
                if ($email === $user[1] && password_verify($pass, $user[2])) {
                    $_SESSION['user_userName'] = $user[0];
                    header("Location: ../home/home.php");
                }
            } else {
                header("Location: ./login.php?error=user");
            }
        } catch (PDOException $ex) {
            echo "Error de PDO" . $ex;
        }
    }
}

require_once './vista/loginVista.php';