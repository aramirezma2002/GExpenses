<?php
$token = openssl_random_pseudo_bytes(16);
$token = bin2hex($token);

$stmt = $pdo->query("INSERT INTO token(id_token, invitant, invitat, id_activitat, data_caducitat) VALUES ('$token', '$userEmail', '$email', '$idActivitat', '$fechaActual')");

$stmtToken = $pdo->query("SELECT id_token, invitant, invitat, id_activitat, data_caducitat FROM token WHERE id_token LIKE '$token'");
$tokens = $stmtToken->fetch();

$stmtInvitat = $pdo->query("SELECT nom, correu FROM usuari WHERE correu LIKE '$tokens[2]'");
$invitat = $stmtInvitat->fetch();

$stmtInvitant = $pdo->query("SELECT nom, correu FROM usuari WHERE correu LIKE '$tokens[1]'");
$invitant = $stmtInvitant->fetch();

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
    <style>
        button {
            background-color: #049dbf;
        }

        a:link {
            color: white;
        }
    </style>
    <div class="principal">

        <div><img src="cid:id" width="100" height="100"></div>
        <div class="mensaje">
            <h1 a>Hola,
                <?php echo $invitat[0] ?>
            </h1>
        </div>
        <div class="mensaje">
            <h3>
                <?php echo $invitant[0] ?> (
                <?php echo $invitant[1] ?>) t'ha invitat a la seguent activitat:
            </h3>
            <div class="actividad">
                <h2>
                    <?php echo $activitat[0] ?>
                </h2>
                <h2>
                    <?php echo $activitat[2] ?>
                    <?php echo $activitat[1] ?>
                </h2>
                <button><a
                        href="/code/screens/email/emailScripts/tokenreader.php?token=<?php echo $token ?>&acceptat=true">Accepta
                        aqui!</a></button>
                <button><a
                        href="/code/screens/email/emailScripts/tokenreader.php?token=<?php echo $token ?>&acceptat=flase">Rebutja
                        l'invitació</a></button>
            </div>
        </div>
    </div>
</body>

</html>