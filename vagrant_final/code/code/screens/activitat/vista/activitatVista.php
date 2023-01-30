<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activitat</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="activitat.css" />
    <link rel="stylesheet" href="../home/home.css" />
</head>

<body>
    <div class="container-arrel">
        <?php include "../plantilla/plantillaHeader.php" ?>

        <?php
        if (isset($_GET["correct"])) {
            if ($_GET["correct"] == "email") {
                echo "<h3 class='correct displayCorrect'>CORRECTE! Els emails se han enviat correctament</h3>";
            }
        }

        if (isset($_GET["error"])) {
            if ($_GET["error"] == "despesa") {
                echo "<h3 class='error displayError'>ERROR! Aquesta despesa ja esta creada</h3>";
            }
        }
        ?>

        <div class="mainBody">
            <div class="activitatMainBody">
                <div class="mainLeftContainer containersMargin">
                    <div class="activitatContainerHeader">
                        <div class="btn-volver">
                            <img width="20px" src="../../recursos/img/volver-flecha-izquierda.png" alt="icono volver">
                        </div>
                        <div class="nomActivitat">
                            <h2>
                                <?php echo $nomActivitat ?>
                            </h2>
                        </div>
                        <div>
                            <button id="btnAfegirDespesa" class="btn-afegir">Afegir</button>
                        </div>

                    </div>


                    <?php if (!$hayDespesas) {
                        echo "<div class='message-null'>Cap despesa creada!</div>";
                    }
                    ?>
                    <div class="despesaDisplayer">


                        <?php while ($row = $stmtDespesa->fetch()) : ?>

                            <?php
                            $separador = "_";
                            $idDespesa = $row["id_despesa"];
                            $separada = explode($separador, $idDespesa);
                            ?>
                            <form class="formDespesaSelect" method="post">
                                <div class="despesa" id="<?php echo $idDespesa ?>">
                                    <input type="text" hidden name="valorIdDespesa" value="<?php echo $idDespesa ?>">
                                    <div class="titol"><?php echo $separada[1] ?></div>
                                    <div class="valor"><?php echo $row["valor_despesa"] . " " . $tMoneda[0] ?></div>
                                </div>
                            </form>

                        <?php endwhile; ?>
                    </div>


                </div>
                <div class="mainRightContainer containersMargin">
                    <div class="usuarisContainerHeader">
                        <div class="tituloMembers">
                            <h2>Miembros</h2>
                        </div>
                        <button class="btn-afegir" id="btnAfegirMembers">Afegir</button>
                    </div>

                    <div class="membersDisplayer">
                        <?php while ($row = $stmtMembers->fetch()) : ?>

                            <div class="member">
                                <div class="nom"><?php echo $row["username"] ?></div>
                                <div class="email"> <?php echo $row["correu"] ?></div>
                            </div>

                        <?php endwhile; ?>
                    </div>

                    <div class="btnBalance">
                        <button id="btnAbrirBalance" class="btn-afegirBalance balanceTimer">Generar balanç</button>
                    </div>
                </div>
            </div>

            <div class="invitacion despesaSelector">
                <div class="modal-container">
                    <div class="modal-header">
                        <div class="despesaSelectorHeader">
                            <h2 class="titolDespesaSelector">Selecciona el tipus de despesa </h2>
                            <div class="closeDespesaSelector">
                                <label class="btn-cerrar-popUp-selectDespesaType"> X </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-margin" id="despesaSelectorPopupBody">
                        <form method="post">
                            <div class="btns">
                                <label for="simple" value="simple"><input name="simple" type="button" id="simple" value="Despesa simple"></label>
                                <label for="avancada" value="avancada"><input name="avancada" type="button" id="avancada" value="Despesa avançada"></label>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <?php
            if (isset($_POST['simpleForm']) && isset($_POST['currentId'])) {
                echo "<a/>";
                $current = $_POST['currentId'];

                if ($pdo != null) {

                    try {
                        $stmtUsuarisActivitat = $pdo->query("SELECT DISTINCT nom_usuari FROM usuari_activitat WHERE nom_activitat LIKE '$current'");

            ?>
                        <div class="invitacion despesaSimpleContainer despesaSelector">
                            <div class="modal-container">
                                <div class="modal-header">
                                    <div class="despesaSelectorHeader">
                                        <h2 class="titolDespesaSimple"><?php echo $nomActivitat ?></h2>
                                    </div>
                                </div>

                                <div class="modal-margin" id="despesaSelectorPopupBody">
                                    <form method="post" class="despesaSimpleForm">
                                        <h3 class="error"></h3>
                                        <div>
                                            <input placeholder="Nom de la despesa" type="text" name="titolDespesaSimple" id="titolDespesaSimple" />
                                            <input placeholder="Quantitat" type="number" name="importDespesaSimple" id="importDespesaSimple" />
                                            <select name="nomPagaDespesaSimple" id="despesaSimpleSelect">
                                                <option value="none">Nom del que paga</option>
                                                <?php while ($val = $stmtLlistarUsuarisActivitat->fetch()) : ?>
                                                    <option value="<?php echo $val["nom_usuari"] ?>"> <?php echo $val["nom_usuari"] ?> </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="btns">
                                            <p><input class="btn-cerrar-popUp-selectDespesaType" type="button" value="Cancelar"></p>
                                            <p><input value="Enviar" type="submit"></p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <script src='ckeckDespesaSimpleInputs.js'></script>

            <?php
                        echo "<script src='homeDespesaSimpleForm.js'></script>";
                    } catch (PDOException $ex) {
                        echo "Error de PDO " . $ex;
                    }
                }
            } ?>


            <?php
            if (isset($_POST['advancedForm']) && isset($_POST['currentId'])) {
                echo "<a/>";
                $current = $_POST['currentId'];

                if ($pdo != null) {

                    try {
                        $stmtUsuarisActivitat = $pdo->query("SELECT DISTINCT nom_usuari FROM usuari_activitat WHERE nom_activitat LIKE '$current'");

            ?>
                        <div class="invitacion despesaSimpleContainer despesaSelector">
                            <div class="modal-container">
                                <div class="modal-header">
                                    <div class="despesaSelectorHeader">
                                        <h2 class="titolDespesaSimple "><?php echo $nomActivitat ?></h2>
                                    </div>
                                </div>

                                <div class="modal-margin" id="despesaSelectorPopupBody">
                                    <h3 class="error"></h3>
                                    <form method="post" class="despesaAvancadaForm">
                                        <h3 class="error"></h3>
                                        <div>
                                            <input placeholder="Nom de la despesa" type="text" name="titolDespesaAvancada" id="titolDespesaAvancada" />
                                            <input placeholder="Quantitat" type="number" name="importDespesaAvancada" id="importDespesaAvancada" />
                                            <div class="addPersonContainer">
                                                <select id="userSelector" name="nomPagaDespesaAvancada">
                                                    <option value="none">Nom del que paga</option>
                                                    <?php while ($val = $stmtLlistarUsuarisActivitat->fetch()) : ?>
                                                        <option value="<?php echo $val["nom_usuari"] ?>"> <?php echo $val["nom_usuari"] ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                                <div id="addUserBtn" class="btn-afegir-activitat">+</div>
                                            </div>

                                            <div class="togglePercentageValueContainer">
                                                <p class="togglePercentageValueText">Tractar com imports</p>
                                                <label class="switch">
                                                    <input id="isValue" name="isValue" type="checkbox">
                                                    <span class="toggleSlider round"></span>
                                                </label>
                                            </div>

                                            <div class="sliderDisplayer">

                                            </div>

                                        </div>
                                        <div class="btns">
                                            <p><input class="btn-cerrar-popUp-selectDespesaType" type="button" value="Cancelar"></p>
                                            <p><input value="Enviar" type="submit" id="enviarDespesaAvancadaBtn"></p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <script src="despesaAvancada.js"></script>

            <?php
                        echo "<script src='homeDespesaSimpleForm.js'></script>";
                    } catch (PDOException $ex) {
                        echo "Error de PDO " . $ex;
                    }
                }
            } ?>


            <?php
            if (isset($_POST['valorIdDespesa'])) {
                $idDespesa = $_POST['valorIdDespesa'];
                if ($pdo != null) {
                    try {
                        $stmtInfoUserDespesa = $pdo->query("SELECT DISTINCT username,valor_per_usuari FROM usuari_despesa WHERE id_despesa LIKE '$idDespesa'");
                        $stmtValorTotal = $pdo->query("SELECT sum(valor_per_usuari) FROM usuari_despesa where id_despesa like '$idDespesa'");
                        $valorTotalDespesa = $stmtValorTotal->fetch();
            ?>

                        <div class="despesaSelect">
                            <div class="despesa-container">
                                <div class="despesa-header">
                                    <?php
                                    $separador = "_";
                                    $separada = explode($separador, $idDespesa);
                                    ?>
                                    <h2 class="titol">Despesa</h2>
                                    <h3 class="subtitulo"><?php echo $separada[1] ?></h3>
                                </div>

                                <div class="despesa-margin">
                                    <div class="userDespesaSelect"> <?php echo $separada[2] ?></div>
                                    <div class="precioDespesaSelect"><?php echo $valorTotalDespesa[0]  . " " . $tMoneda[0] ?></div>
                                </div>

                                <div class="containerUsers">

                                    <?php while ($val = $stmtInfoUserDespesa->fetch()) : ?>
                                        <div class="despesa-margin">
                                            <div class="userDespesaSelect"> <?php echo $val["username"] ?></div>
                                            <div class="precioDespesaSelect"><?php echo $val["valor_per_usuari"]  . " " . $tMoneda[0] ?></div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                <div class="btns-activitat">
                                    <button id="btn-close-despesaSelect">Cerrar</button>
                                </div>

                            </div>
                        </div>
            <?php
                        echo "<script src='mostrarDespesaInfo.js'></script>";
                    } catch (PDOException $ex) {
                        echo "Error de PDO " . $ex;
                    }
                }
            } ?>

            <div class="invitacionMembers">
                <div class="invitacionMembers-container">
                    <div class="invitacionMembers-header">
                        <h2 class="titol">Invitacion</h2>
                        <h3 class="subtitulo"></h3>
                    </div>

                    <div class="invitacionMembers-margin">
                        <h3 class="error"></h3>
                        <form class="invitacionMembers-form" method="POST" id="form-act-invitacion" name="form_act_invitacion">

                            <input type="text" class="hiddenIdActivitatSelector" name="idActivitat" value=""></input>
                            <div class="introduir-dades">

                                <div class="textArea-email">
                                    <ul class="toggle-list">

                                        <li class="toggle input-text">
                                            <input type="text" class="input-textArea" placeholder="Escriu els correus...">
                                        </li>
                                    </ul>
                                </div>

                                <div class="btn-afegir-correo">
                                    <p><input id="btn-afegir-email" type="button" value="Afegir"></input></p>
                                </div>
                            </div>

                            <div class="btnsMembers">
                                <input id="btn-cerrar-invitacion" type="button" value="Cancelar"></p>
                                <input value="Enviar" type="submit"></p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

        <div class="balance">
            <div class="balance-container">
                <div class="balance-header">
                    <h2 class="titol">Balanç de <?php echo $nomActivitat ?></h2>
                    <h3 class="subtitulo"></h3>
                </div>

                <div class="balance-margin">
                    <h3 class="error"></h3>
                    <form class="balance-form" method="POST" id="form-act-balance" name="form_act_balance">
                        <div class="tituloBalance">
                            <div class="tituloB">Resum balanç</div>
                            <div class="tituloB">Calcúl dels deutes</div>
                        </div>
                        <div class="infoBalance">

                            <div class="graficaBalance">

                                <div class="zonaVerde">
                                    <?php ksort($arrayTotalPagat) ?>
                                    <?php foreach ($arrayTotalPagat as $key => $value) : ?>

                                        <?php
                                        if ($value <= 0) {
                                            $porcentaje = 0;
                                            $value = 0;
                                        } else {
                                            $porcentaje = ($value * 100) / max($arrayTotalPagat);
                                        }


                                        //echo $porcentaje; 
                                        ?>

                                        <div class="nomValorVerde"><?php echo $key . " " . $value . " " . $tMoneda[0] ?></div>
                                        <div class="barraGraficaVerde" style="width:<?php echo $porcentaje ?>%"></div>


                                    <?php
                                    endforeach;
                                    ?>


                                </div>

                                <div class="zonaNegra">

                                </div>

                                <div class="zonaRoja">

                                    <?php ksort($arrayTotalPerPersona) ?>
                                    <?php foreach ($arrayTotalPerPersona as $key => $value) : ?>

                                        <?php
                                        if ($value <= 0) {
                                            $porcentaje = 0;
                                            $value = 0;
                                        } else {
                                            $porcentaje = ($value * 100) / max($arrayTotalPerPersona);
                                        }
                                        ?>


                                        <div class="nomValorRojo"><?php echo $key . " " . $value . " " . $tMoneda[0] ?></div>
                                        <div class="barraGraficaRojo" style="width:<?php echo $porcentaje ?>%"></div>

                                    <?php
                                    endforeach;
                                    ?>
                                </div>

                            </div>
                            <div class="textoBalance">
                                <?php
                                foreach ($arrayDeutesTotals as $key => $value) : ?>

                                    <?php
                                    $separar = "-";
                                    $valorS = explode($separar, $key);
                                    ?>

                                    <input type="text" class="hiddenBalanceSelector" name="valor" value=""></input>
                                    <div class="infoDeutes movimiento"><?php echo $valorS[0] ?> ha de pagar al <?php echo $valorS[1] . " " . $value . " " . $tMoneda[0] ?> </div>

                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="btns-activitat ">
                            <button id="btn-close-balance">Cerrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <?php include "../plantilla/plantillaFooter.php" ?>

    <script src="activitatSelectDespesaType.js"></script>
    <script src="activitatSelectDespesa.js"></script>
    <script src="activitatVolverHome.js"></script>
    <script src="activitatInvitacion.js"></script>
    <script src="activitatBalance.js"></script>

</body>

</html>