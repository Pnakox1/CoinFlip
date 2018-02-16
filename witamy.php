<?php 
session_start();
   if ((isset($_SESSION['udanarejestracja']))) 
	{
		header('Location: index.php');
		exit();
	}
    else
    {
        unset($_SESSION['udanarejestracja']);
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> 
    <title>CoinFlip</title>
</head>
<body>
    
Dziękujemy za rejestracje w serwisie! Możesz już się zalogować<br /> <br />   

            <a href="index.php">Powrót do strony logowania</a>
    <br /> <br />
    
    
    <?php 
        if(isset($_SESSION['blad']))
            echo $_SESSION['blad'];
    ?>
    
    
</body>
</html>