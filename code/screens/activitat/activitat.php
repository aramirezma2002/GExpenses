<?php
session_start();

require "../../connections/connection.php";

function consoleLog($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$currentActivity = $_GET["activitat"];
$currentUser = $_SESSION['user_userName'];
$userEmail = $_SESSION['user_email'];
$fechaActual = date("Y-m-d H:i:s");
$fechaDosDias = date("Y-m-d H:i:s", strtotime($fechaActual . "+ 2 days"));

if ($pdo != null) {
    $stmtUserInActvity = $pdo->query("SELECT * FROM usuari_activitat WHERE nom_usuari LIKE '$currentUser' AND nom_activitat LIKE '$currentActivity'");
    $userInActivity = $stmtUserInActvity->fetch();

    if ($userInActivity[0] != null && $userInActivity[1] != null) {
        $stmtNomActivitat = $pdo->query("SELECT nom FROM activitat WHERE id LIKE '$currentActivity'");
        $nomActivitat = $stmtNomActivitat->fetch();

        $nomActivitat = $nomActivitat[0];

        /*
        Insertar despesa en activitat:
        */
        $stmtnomDespesa = $pdo->query("SELECT * FROM despesa WHERE id_despesa LIKE '$currentActivity'");
        $nomDespesa = $stmtnomDespesa->fetch();

        if (isset($_POST["titolDespesaSimple"]) || isset($_POST["importDespesaSimple"]) && isset($_POST["nomPagaDespesaSimple"])) {
            $nomPagador = htmlentities($_POST["nomPagaDespesaSimple"]) . "";

            $current = $currentActivity;

            $stmtCountUsuaris = $pdo->query("SELECT DISTINCT COUNT(*) FROM usuari_activitat WHERE nom_activitat LIKE '$current'");
            $countUsuaris = $stmtCountUsuaris->fetch();
            if ($countUsuaris[0] >= 1) {

                if ($nomPagador !== "none") {

                    $titolDespesaSimple = trim(htmlentities($_POST["titolDespesaSimple"]));
                    $importDespesaSimple = $_POST["importDespesaSimple"];

                    $qtyPerPerson = $importDespesaSimple / $countUsuaris[0];

                    $stmtInsertDespeses = $pdo->prepare("INSERT INTO despesa(id_despesa, valor_despesa,id_activitat) VALUES (?,?,?)");

                    $stmtInsertDespeses->bindParam(1, $_idDespesa);
                    $stmtInsertDespeses->bindParam(2, $_valorDespesa);
                    $stmtInsertDespeses->bindParam(3, $_idActivitat);

                    $pruebaIdDespesa = $currentActivity . "_" . $titolDespesaSimple . "_" . $nomPagador;

                    $stmtPruebaIdDespesa = $pdo->query("SELECT COUNT(*) FROM despesa WHERE id_despesa LIKE '$pruebaIdDespesa'");
                    $valorIdDespesa = $stmtPruebaIdDespesa->fetch();


                    if ($valorIdDespesa[0] != 0) {
                        header("Location: ./activitat.php?activitat=" . $currentActivity . "&error=despesa");
                    } else {

                        try {
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $pdo->beginTransaction();

                            //datos primer insert
                            $_idDespesa = $currentActivity . "_" . $titolDespesaSimple . "_" . $nomPagador;

                            $_valorDespesa = $importDespesaSimple;

                            $_idActivitat = $currentActivity;

                            $stmtSelect = $pdo->query("UPDATE activitat SET despeses_totals = (despeses_totals + $_valorDespesa), data_modify = CURRENT_TIMESTAMP WHERE id LIKE '$currentActivity'");

                            $stmtInsertDespeses->execute();

                            $pdo->commit();
                        } catch (PDOException $ex) {
                            $pdo->rollBack();
                            echo 'Error: ' . $ex->getMessage();
                        }

                        $stmtInsertDespesesUsuari = $pdo->prepare("INSERT INTO usuari_despesa(username,id_despesa, valor_per_usuari) VALUES (?,?,?)");

                        $stmtInsertDespesesUsuari->bindParam(1, $_idUsuariUsuariDespeses);
                        $stmtInsertDespesesUsuari->bindParam(2, $_idDespesaUsuariDespeses);
                        $stmtInsertDespesesUsuari->bindParam(3, $_qtyPerPerson);

                        $stmtUsuarisActivitat = $pdo->query("SELECT nom_usuari FROM usuari_activitat WHERE nom_activitat LIKE '$currentActivity'");

                        while ($val = $stmtUsuarisActivitat->fetch()) :
                            try {
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $pdo->beginTransaction();

                                //datos primer insert
                                $_idUsuariUsuariDespeses = $val["nom_usuari"];
                                $_idDespesaUsuariDespeses = $currentActivity . "_" . $titolDespesaSimple . "_" . $nomPagador;
                                $_qtyPerPerson = $qtyPerPerson;
                                $stmtInsertDespesesUsuari->execute();

                                $pdo->commit();
                            } catch (PDOException $ex) {
                                $pdo->rollBack();
                                echo 'Error: ' . $ex->getMessage();
                            }
                        endwhile;
                        header("Location: ./activitat.php?activitat=" . $currentActivity);
                    }
                }
            }
        }

        if (isset($_POST["titolDespesaAvancada"]) && isset($_POST["importDespesaAvancada"]) && isset($_POST["userNames"]) && isset($_POST["imports"])) {
            $titolDespesaAvancada = trim($_POST["titolDespesaAvancada"]);
            $importDespesaAvancada = $_POST["importDespesaAvancada"];
            $usernames = $_POST["userNames"];
            $imports = $_POST["imports"];

            $stmtInsertDespesesAvancades = $pdo->prepare("INSERT INTO despesa(id_despesa, valor_despesa, id_activitat) VALUES (?,?,?)");

            $stmtInsertDespesesAvancades->bindParam(1, $_idDespesaAvancada);
            $stmtInsertDespesesAvancades->bindParam(2, $_valorDespesaAvancada);
            $stmtInsertDespesesAvancades->bindParam(3, $_idActivitat);

            $pruebaIdDespesa = $currentActivity . "_" . $titolDespesaAvancada . "_" . $currentUser;

            $stmtPruebaIdDespesa = $pdo->query("SELECT COUNT(*) FROM despesa WHERE id_despesa LIKE '$pruebaIdDespesa'");
            $valorIdDespesa = $stmtPruebaIdDespesa->fetch();

            if ($valorIdDespesa[0] != 0) {
                header("Location: ./activitat.php?activitat=" . $currentActivity . "&error=despesa");
            } else {

                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();

                    //datos primer insert
                    $_idDespesaAvancada = $currentActivity . "_" . $titolDespesaAvancada . "_" . $currentUser;

                    $_valorDespesaAvancada = $importDespesaAvancada;
                    $_idActivitat = $currentActivity;

                    $stmtSelect = $pdo->query("UPDATE activitat SET despeses_totals = (despeses_totals + $_valorDespesaAvancada), data_modify = CURRENT_TIMESTAMP WHERE id LIKE '$currentActivity'");

                    $stmtInsertDespesesAvancades->execute();

                    $pdo->commit();
                } catch (PDOException $ex) {
                    $pdo->rollBack();
                    echo 'Error: ' . $ex->getMessage();
                }


                $stmtInsertDespesesAvancadesUsuari = $pdo->prepare("INSERT INTO usuari_despesa(username,id_despesa, valor_per_usuari) VALUES (?,?,?)");

                $stmtInsertDespesesAvancadesUsuari->bindParam(1, $_idUsuariUsuariDespesesAvancades);
                $stmtInsertDespesesAvancadesUsuari->bindParam(2, $_idDespesaUsuariDespesesAvancades);
                $stmtInsertDespesesAvancadesUsuari->bindParam(3, $_qtyPerPersonAvancada);

                foreach ($usernames as $key => $username) {
                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->beginTransaction();


                        //datos primer insert
                        $_idUsuariUsuariDespesesAvancades = $username;
                        $_idDespesaUsuariDespesesAvancades = $currentActivity . "_" . $titolDespesaAvancada . "_" . $currentUser;
                        $_qtyPerPersonAvancada = $imports[$key];
                        $stmtInsertDespesesAvancadesUsuari->execute();

                        $pdo->commit();
                    } catch (PDOException $ex) {
                        $pdo->rollBack();
                        echo 'Error: ' . $ex->getMessage();
                    }
                }
                header("Location: ./activitat.php?activitat=" . $currentActivity);
            }
        }

        $stmtLlistarUsuarisActivitat = $pdo->query("SELECT nom_usuari FROM usuari_activitat WHERE nom_activitat LIKE '$currentActivity'");
        //__________________________________________________________________________________________________
        //MOSTRAR DATOS DESPESA:


        if ($pdo != null) {
            try {
                $stmtDespesa = $pdo->query("SELECT DISTINCT d.id_despesa, d.valor_despesa FROM despesa AS d WHERE d.id_activitat LIKE'$currentActivity'");
            } catch (PDOException $ex) {
                echo "ERROR de PDO" . $ex;
            }
        }

        if ($pdo != null) {
            try {
                $stmtTipoMoneda = $pdo->query("SELECT DISTINCT d.divisa FROM activitat AS d WHERE d.id LIKE'$currentActivity'");
                $tMoneda = $stmtTipoMoneda->fetch();
            } catch (PDOException $ex) {
                echo "ERROR de PDO" . $ex;
            }
        }

        //__________________________________________________________________________________________________
        //MOSTRAR DATOS DESPESA:

        if ($pdo != null) {
            try {
                $stmtMembers = $pdo->query("SELECT DISTINCT u.username, u.nom, u.correu FROM usuari AS u INNER JOIN usuari_activitat ON usuari_activitat.nom_usuari = u.username WHERE usuari_activitat.nom_activitat LIKE '$currentActivity' ORDER BY(username)");
            } catch (PDOException $ex) {
                echo "Error de PDO " . $ex;
            }
        }

        if ($pdo != null) {
            try {
                $stmtMembersBalance = $pdo->query("SELECT DISTINCT u.username, u.nom, u.correu FROM usuari AS u INNER JOIN usuari_activitat ON usuari_activitat.nom_usuari = u.username WHERE usuari_activitat.nom_activitat LIKE '$currentActivity' ORDER BY(username)");
            } catch (PDOException $ex) {
                echo "Error de PDO " . $ex;
            }
        }

        //------------------------------------------------------------------------------------------
        if ($pdo != null) {
            $stmtCardDespesa = $pdo->query("SELECT COUNT(*) from despesa WHERE id_activitat LIKE '$currentActivity'");
            $cardDespesa = $stmtCardDespesa->fetch();
            $hayDespesas = false;
            if ($cardDespesa[0] != 0) {

                $hayDespesas = true;
            }
        }
        //GUARDAR DATOS INVITACION
        if (isset($_POST['invitatioMembers'])) {

            $arrayCorreos = $_POST['invitatioMembers'];
            $idActivitat = $currentActivity;

            foreach ($_POST['invitatioMembers'] as $email) {
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
                            $_invitador = $currentUser;
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
            enviarCorreo("Location: ./activitat.php?activitat=" . $idActivitat . "&correct=email", $arrayCorreos, $userEmail, $idActivitat, $fechaActual);
        }



        if ($pdo != null) {

            $separadorT = "_";

            if (isset($_POST["valorBalance"])) {

                $stmtDatosBalanceComprobar = $pdo->query("SELECT distinct ud.username,ud.id_despesa,ud.valor_per_usuari,despesa.valor_despesa FROM usuari_despesa as ud inner join despesa on despesa.id_despesa = ud.id_despesa AND despesa.id_activitat LIKE '$currentActivity'");
                $separadorB = "-";

                while ($row = $stmtDatosBalanceComprobar->fetch()) {

                    $userName = $row["username"];
                    $idDespesa = $row["id_despesa"];
                    $separada = explode($separadorT, $idDespesa);

                    foreach ($_POST["valorBalance"] as $key => $value) {

                        $nomPagDeb = explode($separadorB, $value);


                        if ($nomPagDeb[0] == $userName && $nomPagDeb[1] == $separada[2]) {
                            try {
                                $stmtinsertPagament = $pdo->prepare("INSERT INTO pagament(username,pagador_despesa,id_despesa,id_activitat) VALUES (?,?,?,?)");

                                $stmtinsertPagament->bindParam(1, $_username);
                                $stmtinsertPagament->bindParam(2, $_pagadorDespesa);
                                $stmtinsertPagament->bindParam(3, $_idDespesa);
                                $stmtinsertPagament->bindParam(4, $_idActivitat);

                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $pdo->beginTransaction();

                                    //datos primer insert
                                    $_username = $userName;
                                    $_pagadorDespesa = $separada[2];
                                    $_idDespesa = $idDespesa;
                                    $_idActivitat = $currentActivity;
                                    $stmtinsertPagament->execute();

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
                }
            }

            try {
                $stmtDatosBalance = $pdo->query("SELECT distinct ud.username,ud.id_despesa,ud.valor_per_usuari,despesa.valor_despesa FROM usuari_despesa as ud inner join despesa on despesa.id_despesa = ud.id_despesa AND despesa.id_activitat LIKE '$currentActivity'");



                //el total que debe cada persona
                $arrayTotalPerPersona = [];
                //el total de las despesas que debe una persona a otra
                $arrayDeutesTotals = [];
                //lo que la gente te ha pagado
                $arrayPagaments = [];
                //lo que has pagado
                $arrayTotalPagat = [];


                while ($row = $stmtDatosBalance->fetch()) {


                    $userName = $row["username"];
                    $idDespesa = $row["id_despesa"];
                    $separada = explode($separadorT, $idDespesa);

                    $variable = $row["username"] . "-" . $separada[2] . "_" . $row["valor_per_usuari"];


                    //si el que paga y el que le pagan es la misma persona le resta el total.
                    if ($row["username"] == $separada[2]) {

                        //tendra que pillar el valor_despesa - lo que ya ha pagado
                        //para saber del total pagado usuario
                        if (!array_key_exists($separada[2], $arrayTotalPagat)) {
                            $arrayTotalPagat[$separada[2]] = $row["valor_despesa"] - $row["valor_per_usuari"];
                        } else {
                            $arrayTotalPagat[$separada[2]] = $arrayTotalPagat[$separada[2]] + $row["valor_despesa"] - $row["valor_per_usuari"];
                        }

                        //$arrayPagaments[$row["username"]] = $row["valor_despesa"] - $row["valor_per_usuari"]; 
                    } else {


                        if (!array_key_exists($row["username"], $arrayTotalPerPersona)) {
                            $arrayTotalPerPersona[$row["username"]] = $row["valor_per_usuari"];
                            //echo $arrayTotalPerPersona[$row["username"]];

                        } else {
                            $restaDespesas = $arrayTotalPerPersona[$row["username"]] + $row["valor_per_usuari"];
                            $arrayTotalPerPersona[$row["username"]] = $restaDespesas;
                        }

                        //echo $row["username"]. " " . $arrayTotalPerPersona[$row["username"]];

                        if (!array_key_exists($row["username"] . "-" . $separada[2], $arrayDeutesTotals)) {
                            $arrayDeutesTotals[$row["username"] . "-" . $separada[2]] = $row["valor_per_usuari"];
                        } else {
                            $sumaDespesasTotals = $arrayDeutesTotals[$row["username"] . "-" . $separada[2]] + $row["valor_per_usuari"];
                            $arrayDeutesTotals[$row["username"] . "-" . $separada[2]] = $sumaDespesasTotals;
                        }

                        //echo $row["username"];

                        $stmtCount = $pdo->query("SELECT COUNT(*) FROM usuari_despesa WHERE id_despesa LIKE '$idDespesa' AND username IN ('$userName','$separada[2]') HAVING COUNT(*) = 2");
                        $datosCount = $stmtCount->fetch();

                        //echo $separada[2];
                        //echo print_r($datosCount);

                        $stmtCountDatosBalance = $pdo->query("SELECT COUNT(*) FROM pagament WHERE username LIKE '$userName' AND pagador_despesa LIKE '$separada[2]' AND id_despesa LIKE '$idDespesa'");
                        $datosBalance = $stmtCountDatosBalance->fetch();

                        //echo print_r($datosBalance);

                        //si no esta pagado me hace el total que debe
                        //echo print_r($datosCount);
                        if ($datosBalance[0] != 0 && $datosCount[0] != 0) {
                            if (intval($datosBalance[0]) == intval($datosCount[0]) / 2) {
                                if (!array_key_exists($row["username"], $arrayTotalPerPersona)) {
                                    $arrayTotalPerPersona[$row["username"]] = $row["valor_per_usuari"];
                                } else {
                                    $sumaDespesasTotals = $arrayTotalPerPersona[$row["username"]] - $row["valor_per_usuari"];
                                    $arrayTotalPerPersona[$row["username"]] = $sumaDespesasTotals;
                                }

                                //echo $userName . $arrayTotalPagat[$userName] . "</br>";
                                //echo print_r($arrayPagaments[$userName]);
                                if (!array_key_exists($separada[2], $arrayPagaments)) {
                                    $arrayPagaments[$separada[2]] = $arrayDeutesTotals[$row["username"] . "-" . $separada[2]];
                                } else {
                                    $arrayPagaments[$separada[2]] = $arrayPagaments[$separada[2]] + $arrayDeutesTotals[$row["username"] . "-" . $separada[2]];
                                }

                                unset($arrayDeutesTotals[$row["username"] . "-" . $separada[2]]);
                            } else {

                                $restaDespesas = $arrayTotalPerPersona[$row["username"]] - $row["valor_per_usuari"];
                                $arrayTotalPerPersona[$row["username"]] = $restaDespesas;

                                //lo que ha pagado ya el usr
                                //$arrayPagaments[$separada[2]] = $row["valor_per_usuari"];
                            }
                        }
                    }

                }

                foreach ($arrayTotalPagat as $separada => $value) {
                    if (array_key_exists($separada, $arrayPagaments) && array_key_exists($separada, $arrayTotalPagat)) {
                        if ($value - $arrayPagaments[$separada] < 0) {
                            $arrayTotalPagat[$separada] = 0;
                        } else {
                            $arrayTotalPagat[$separada] = $value - $arrayPagaments[$separada];
                        }
                    }
                }

            } catch (PDOException $ex) {
                echo "Error de PDO " . $ex;
            }
        }

        include "./vista/activitatVista.php";
    } else {

        header("Location: ../home/home.php?error=noEnActivitat");
    }
}
