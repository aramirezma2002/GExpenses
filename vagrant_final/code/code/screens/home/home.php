<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login/login.php");
} else {

    require "../../connections/connection.php";

    $userName = $_SESSION['user_userName'];
    $userEmail = $_SESSION['user_email'];
    $fechaActual = date("Y-m-d H:i:s");
    $fechaDosDias = date("Y-m-d H:i:s", strtotime($fechaActual . "+ 2 days"));

    //echo $fechaDosDias;
    //------------------------------------------------------------------------------------------
    //GUARDAR DATOS ACTIVITAT
    if (
        isset($_POST['act_nom']) &&
        isset($_POST['Moneda'])
    ) {
        $nomActivitat = htmlentities($_POST['act_nom']) . "";
        $moneda = htmlentities($_POST['Moneda']) . "";

        $_SESSION['act_nom'] = $nomActivitat;
        $_SESSION['Moneda'] = $moneda;


        require "../../connections/connection.php";

        if ($pdo != null) {

            $stmtNomActivitat = $pdo->query("SELECT id FROM activitat WHERE id LIKE '$userName-$nomActivitat'");
            $activitatTrobada = $stmtNomActivitat->fetch();

            if ($activitatTrobada == null) {

                $stmtinsertActivitat = $pdo->prepare("INSERT INTO activitat(id,nom,data_creacio,divisa,despeses_totals,creador) VALUES (?,?,?,?,?,?)");

                $stmtinsertActivitat->bindParam(1, $_id);
                $stmtinsertActivitat->bindParam(2, $_nomActivitat);
                $stmtinsertActivitat->bindParam(3, $_tempsActual);
                $stmtinsertActivitat->bindParam(4, $_moneda);
                $stmtinsertActivitat->bindParam(5, $_despesaTotal);
                $stmtinsertActivitat->bindParam(6, $_SESSION['user_userName']);


                $stmtinsertUserActivitat = $pdo->prepare("INSERT INTO usuari_activitat VALUES (?,?)");

                $stmtinsertUserActivitat->bindParam(1, $_idActividad);
                $stmtinsertUserActivitat->bindParam(2, $_userName);

                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();

                    //datos primer insert
                    $_id = "$userName-$nomActivitat";
                    $_nomActivitat = $nomActivitat;
                    $_tempsActual = $fechaActual;
                    $_moneda = $moneda;
                    $_despesaTotal = 0;
                    $stmtinsertActivitat->execute();

                    $pdo->commit();
                } catch (PDOException $ex) {
                    $pdo->rollBack();
                    echo 'Error: ' . $ex->getMessage();
                }

                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();

                    //datos segundo insert
                    $_idActividad = "$userName-$nomActivitat";
                    $_userName = $userName;
                    $stmtinsertUserActivitat->execute();

                    $pdo->commit();
                } catch (PDOException $ex) {
                    $pdo->rollBack();
                    echo 'Error: ' . $ex->getMessage();
                }
                header("Location: ./home.php");

            } else {
                header("Location: ./home.php?error=activitat");
            }
        }
    }

    //------------------------------------------------------------------------------------------
    //GUARDAR DATOS INVITACION
    if (isset($_POST['invitation']) && isset($_POST['idActivitat'])) {

        $arrayCorreos = $_POST['invitation'];
        $idActivitat = $_POST['idActivitat'];

        echo $idActivitat;

        foreach ($_POST['invitation'] as $email) {
            if ($pdo != null) {
                try {
                    $stmtinsertInvitacio = $pdo->prepare("INSERT INTO invitacio(invitador,id_activitat,data_creacio,data_caducitat,invitat,acceptat) VALUES (?,?,?,?,?,?)");

                    $stmtinsertInvitacio->bindParam(1, $_invitador);
                    $stmtinsertInvitacio->bindParam(2, $_idActivitat);
                    $stmtinsertInvitacio->bindParam(3, $_dataCreacio);
                    $stmtinsertInvitacio->bindParam(4, $_dataCaducitat);
                    $stmtinsertInvitacio->bindParam(5, $_invitat);
                    $stmtinsertInvitacio->bindParam(6, $_acceptat);

                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->beginTransaction();

                        //datos primer insert
                        $_invitador = $userName;
                        $_idActivitat = $idActivitat;
                        $_dataCreacio = $fechaActual;
                        $_dataCaducitat = $fechaDosDias;
                        $_invitat = $email;
                        $_acceptat = 0;
                        $stmtinsertInvitacio->execute();

                        $pdo->commit();
                    } catch (PDOException $ex) {
                        $pdo->rollBack();
                        echo 'Error: ' . $ex->getMessage();
                    }

                } catch (PDOException $ex) {
                    echo "Error de PDO " . $ex;
                }
            }
        }

        require_once "../email/plantillas/notificacion.php";
        enviarCorreo("Location: ./home.php?correct=email", $arrayCorreos, $userEmail, $idActivitat, $fechaActual);
    }
    //------------------------------------------------------------------------------------------
    //ELIMINAR LA ACTIVIDAD
    if (isset($_POST['idActivitatEliminar'])) {
        $idActivitat = $_POST['idActivitatEliminar'];

        if ($pdo != null) {
            try {
                //$stmtEliminarActivitatUsuari = $pdo->query("DELETE FROM usuari_despes WHERE nom_activitat='$idActivitat'");
                $stmtEliminarActivitatDespesa = $pdo->query("DELETE FROM usuari_activitat WHERE nom_activitat='$idActivitat'");
                $stmtEliminarActivitat = $pdo->query("DELETE FROM activitat WHERE id='$idActivitat'");

            } catch (PDOException $ex) {
                echo "Error de PDO " . $ex;
            }
        }
    }



    //------------------------------------------------------------------------------------------
    //MOSTRAR DATOS ACTIVIDAD
    if ($pdo != null) {
        try {
            $stmtActivitat = $pdo->query("SELECT DISTINCT a.id,a.nom,a.data_creacio,a.divisa,a.despeses_totals FROM activitat AS a INNER JOIN usuari_activitat ON usuari_activitat.nom_activitat = a.id WHERE usuari_activitat.nom_usuari LIKE '$userName' ORDER BY(nom)");
        } catch (PDOException $ex) {
            echo "Error de PDO " . $ex;
        }
    }

    //MOSTRAR DATOS DEPENDIENDO DEL SELECTOR
    if (isset($_POST["selector"])) {
        $selector = $_POST["selector"];

        if ($selector == "dateCreate") {
            if ($pdo != null) {
                try {
                    $stmtActivitat = $pdo->query("SELECT DISTINCT a.id,a.nom,a.data_creacio,a.divisa,a.despeses_totals FROM activitat AS a INNER JOIN usuari_activitat ON usuari_activitat.nom_activitat = a.id WHERE usuari_activitat.nom_usuari LIKE '$userName' ORDER BY a.data_creacio ASC");
                } catch (PDOException $ex) {
                    echo "Error de PDO " . $ex;
                }
            }
        } else if ($selector == "endModify") {
            if ($pdo != null) {
                try {
                    $stmtActivitat = $pdo->query("SELECT a.id,a.nom,a.data_creacio,a.divisa,a.despeses_totals,a.data_modify FROM activitat AS a INNER JOIN usuari_activitat ON usuari_activitat.nom_activitat = a.id WHERE usuari_activitat.nom_usuari LIKE '$userName' ORDER BY a.data_modify DESC");
                } catch (PDOException $ex) {
                    echo "Error de PDO " . $ex;
                }
            }
        }
    }
    // MENSAJE - NO HAY ACTIVIDADES 
    if ($pdo != null) {
        $stmtCardActivitat = $pdo->query("SELECT COUNT(*) from usuari_activitat WHERE nom_usuari LIKE '$userName'");
        $cardActivitat = $stmtCardActivitat->fetch();
        $hayActividades = false;
        if ($cardActivitat[0] != 0) {

            $hayActividades = true;

        }

    }

    //------ ------------------------------------------------------------------------------------

    $i = 0;

    include "./vista/homeVista.php";
}