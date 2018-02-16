<?php   
    session_start();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> 
    <title>CoinFlip</title>
</head>
<body>
    <?php 
        echo "<p>Witaj ".$_SESSION['login']."!";
        echo "<p>Twój stan konta wynosi  ".$_SESSION['value']." smoczych monet";
    ?>
</body>
</html>