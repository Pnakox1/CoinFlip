<?php 
session_start()
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> 
    <title>CoinFlip</title>
</head>
<body>
    
    Bogaci będa biednymi - Przemek 2k18
    
    <form action="zaloguj.php" method="post" >
    Login <br /> <input type="text" name="login" /> <br/>
    Haslo <br /> <input type="password" name="haslo" /> <br/> <br/>
    <input type="submit" value="Zaloguj się" />
    
    </form>
    <?php 
        if(isset($_SESSION['blad']))
            echo $_SESSION['blad'];
    ?>
    
    
</body>
</html>