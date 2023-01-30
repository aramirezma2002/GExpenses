<?php
include "../../../connections/connection.php";

if ($pdo != null) {
    try {
        $acceptat = $_GET["acceptat"];

        $token = $_GET["token"];

        $stmtToken = $pdo->query("SELECT id_token, invitat, id_activitat, data_caducitat FROM token WHERE id_token LIKE '$token'");

        $tokenInfo = $stmtToken->fetch();

        if ($acceptat == "true") {
            if ($tokenInfo != null) {
                $stmtUser = $pdo->query("SELECT username FROM usuari WHERE correu LIKE '$tokenInfo[1]'");

                $user = $stmtUser->fetch();

                if ($user != null) {
                    $stmtDeleteInv = $pdo->query("DELETE FROM invitacio WHERE invitador LIKE '$user[0]'");
                    $stmtInsertAct = $pdo->query("INSERT INTO usuari_activitat(nom_usuari, nom_activitat) VALUES ('$user[0]', '$tokenInfo[2]')");
                    header("Location: /Code/screens/home/home.php");
                } else {
                    include "./registerInsert.php";
                    echo "<a hidden>";
                    echo "<script src='emailForm.js'></script>";
                }
            }
        }
    } catch (PDOException $ex) {
        echo "Error de PDO" . $ex;
    }
}


