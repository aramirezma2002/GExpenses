<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="home.css" />

</head>

<body>
    <div class="container-arrel">
        <?php include "../plantilla/plantillaHeader.php" ?>

        <div class="mainBody">
            <div class="mainContainer">
                <div class="paramDiv">
                    <button id="btn-abrir-popUp" class="btn-afegir">+ Afegir</button>
                    <form action="" method="post">
                        <select name="selector" id="" class="selector" onchange="this.form.submit()">
                            <option value="defaultSelect">Selecciona</option>
                            <option value="dateCreate">Data creació</option>
                            <option value="endModify">Última modificació</option>
                        </select>
                    </form>

                </div>

                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "activitat") {
                        echo "<h3 class='error displayError'>ERROR! Ja hi ha una activitat amb aquest nom!</h3>";
                    }

                    if ($_GET["error"] == "noEnActivitat") {
                        echo "<h3 class='error displayError'>ERROR! No estas registrat en aquesta activitat!</h3>";
                    }
                }

                if (isset($_GET["correct"])) {
                    if ($_GET["correct"] == "email") {
                        echo "<h3 class='correct displayCorrect'>CORRECTE! Els emails se han enviat correctament</h3>";
                    }
                }
                ?>
 <?php
                if (!$hayActividades) {
                    echo "<div class='message-null'>Cap activitat creada!</div>";
                }
                ?>
                <div class="cardsDisplayer">
                        
                    <?php while ($row = $stmtActivitat->fetch()): ?>
                        <div class="card">
                            <div class="cardImgContainer">
                                <img src="pingu.png" width="50px" alt="">
                            </div>

                            <div class="principal">
                                <div class="cardInfo">
                                    <label id="<?php echo $row['id'] ?>" class="hiddenLabelSelector" hidden></label>
                                    <div class="cardInfoTitle">
                                        <div class="titulo"><?php echo $row["nom"] ?></div>
                                        <div>
                                            <p>Gastos: <?php echo $row["despeses_totals"] . "  " . $row["divisa"] ?></p>
                                            <p>Fecha: <?php echo $newDate = date("d/m/Y H:i", strtotime($row["data_creacio"])); ?></p>
                                        </div>
                                    </div>
                                    <div class="btns-card">

                                        <a class="btn-abrir-invitaciones">
                                            <img src="../../recursos/add-group.png" class="btn-abrir-invitacion" alt="">
                                        </a>
                                        <a class="btn-eliminar">
                                            <img src="../../recursos/eliminar.png" class="btn-eliminar" alt="">
                                        </a>
                                    </div>
                                </div>
                                <?php

                                $idActividad = $row['id'];
                                if ($pdo != null) {
                                    try {
                                        $stmtMembers = $pdo->query("SELECT DISTINCT COUNT(*) FROM usuari_activitat WHERE nom_activitat LIKE '$idActividad'");
                                        $valorMembers = $stmtMembers->fetch();
                                    } catch (PDOException $ex) {
                                        echo "Error de PDO " . $ex;
                                    }
                                }
                                ?>
                                <div class="members">
                                    <img src="../../recursos/group.png" alt="">
                                    <div>: <?php echo $valorMembers[0] ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="invitacion">
                <div class="invitacion-container">
                    <div class="invitacion-header">
                        <h2 class="titol">Invitacion</h2>
                        <h3 class="subtitulo"></h3>
                    </div>

                    <div class="invitacion-margin">
                        <h3 class="error"></h3>
                        <form class="invitacion-form" method="POST" id="form-act-invitacion" name="form_act_invitacion">

                            <input type="text" class="hiddenIdActivitatSelector" name="idActivitat" value=""></input>
                            <div class="introduir-dades">

                                <div class="textArea-email">
                                    <ul class="toggle-list">

                                        <li class="toggle input-text">
                                            <input type="text" class="input-textArea"
                                                placeholder="Escriu els correus...">
                                        </li>
                                    </ul>
                                </div>

                                <div class="btn-afegir-correo">
                                    <p><input id="btn-afegir-email" type="button" value="Afegir"></input></p>
                                </div>
                            </div>

                            <div class="btns">
                                <input id="btn-cerrar-invitacion" type="button" value="Cancelar"></p>
                                <input value="Enviar" type="submit"></p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="eliminar">
                <div class="eliminar-container">
                    <div class="eliminar-header">
                        <h2 class="titol">ELIMINAR</h2>
                        <h3 class="subtituloEliminar"></h3>
                    </div>

                    <div class="eliminar-margin">
                        <form class="eliminar-form" method="POST" id="form-act-eliminar" name="form_act_invitacion">
                            <div class="btns">
                                <input type="text" class="hiddenEliminarIdActividad" name="idActivitatEliminar"
                                    value=""></input>
                                <input id="btn-cerrar-eliminar" class="input" type="button" value="Cancelar">
                                <input value="Eliminar" class="input" type="submit">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <?php include "../plantilla/plantillaFooter.php" ?>
    </div>
    <script src="homeActivitatForm.js"></script>
    <script src="homeCardsActionController.js"></script>

</body>

</html>