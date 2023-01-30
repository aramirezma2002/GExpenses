<?php

session_start();
$username = null;
$name = null;
$surname = null;
$email = null;
$remail = null;
$pass = null;
$rpass = null;

if (
    isset($_POST['user_userName']) &&
    isset($_POST['user_nombre']) &&
    isset($_POST['user_apellido']) &&
    isset($_POST['user_email']) &&
    isset($_POST['user_rEmail']) &&
    isset($_POST['user_pass']) &&
    isset($_POST['user_rPass'])
) {
    $username = htmlentities($_POST['user_userName']) . "";
    $name = htmlentities($_POST['user_nombre']) . "";
    $surname = htmlentities($_POST['user_apellido']) . "";
    $email = htmlentities($_POST['user_email']) . "";
    $remail = htmlentities($_POST['user_rEmail']) . "";
    $pass = htmlentities($_POST['user_pass']) . "";
    $rpass = htmlentities($_POST['user_rPass']) . "";

    $_SESSION['user_userName'] = $username;
    $_SESSION['user_nombre'] = $name;
    $_SESSION['user_apellido'] = $surname;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_rEmail'] = $remail;
    $_SESSION['user_pass'] = $pass;
    $_SESSION['user_rPass'] = $rpass;

    if ($pdo != null) {
        try {
            $stmtUser = $pdo->query("SELECT username FROM usuari WHERE username LIKE '$username'");
            $stmtEmail = $pdo->query("SELECT correu FROM usuari WHERE correu LIKE '$email'");

            $queryUsername = $stmtUser->fetch();
            $queryEmail = $stmtEmail->fetch();

            if ($queryUsername == null && $queryEmail == null) {
                if ($email == $remail) {
                    if ($pass == $rpass) {
                        $passCrypt = password_hash($pass, PASSWORD_DEFAULT);
                        $pdo->query("INSERT INTO usuari VALUES ('$username', '$name', '$surname', '$email', '$passCrypt')");
                        $pdo->query("INSERT INTO usuari_activitat(nom_usuari, nom_activitat) VALUES ('$username', '$tokenInfo[2]')");
                        header("Location: /code/screens/home/home.php");
                    }
                }
            }
        } catch (PDOException $ex) {
            echo "Error de PDO " . $ex;
        }
    }
}
