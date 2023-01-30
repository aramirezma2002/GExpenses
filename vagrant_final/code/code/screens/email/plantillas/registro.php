<?php
$token = openssl_random_pseudo_bytes(16);
$token = bin2hex($token);

$stmt = $pdo->query("INSERT INTO token(id_token, invitant, invitat, id_activitat, data_caducitat) VALUES ('$token', '$userEmail', '$email', '$idActivitat', '$fechaActual')");

$stmtToken = $pdo->query("SELECT id_token, invitant, invitat, id_activitat, data_caducitat FROM token WHERE id_token LIKE '$token'");
$tokens = $stmtToken->fetch();

$stmtInvitant = $pdo->query("SELECT nom, correu FROM usuari WHERE correu LIKE '$tokens[1]'");
$invitatant = $stmtInvitant->fetch();

$stmtActivitat = $pdo->query("SELECT nom, divisa, despeses_totals FROM activitat WHERE id LIKE '$tokens[3]'");
$activitat = $stmtActivitat->fetch();
?>

<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="home.css" />

</head>

<body>
    <div class="principal" weight="600" height="600">
        <div><img src="../../../recursos/img/presupuesto(1).png" width="100" height="100"></div>
        <div class="mensaje">
            <h1>Hola!</h1>
        </div>
        <div class="mensaje">
            <h3><? echo $invitant[0] ?>(<? echo $invitant[1] ?>) t'ha invitat a la seguent activitat:</h3>
            <div class="actividad">
                <h2><? echo $activitat[0] ?></h2>
                <h2><? echo $activitat[2] ?> <? echo $activitat[1] ?></h2>
                <a href="http://localhost:1232/code/screens/email/emailScripts/tokenreader.php?token=<?php echo $token ?>&acceptat=true">Registra't per acceptar la invitació!</a>
                <a href="http://localhost:1232/code/screens/email/emailScripts/tokenreader.php?token=<?php echo $token ?>&acceptat=flase">Rebiutja l'invitació</a>
            </div>
        </div>
    </div>
</body>

</body>

</html>