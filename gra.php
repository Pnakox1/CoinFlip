<?php   
    session_start();
    
    if (!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
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
    <?php 
        echo "<p>Witaj ".$_SESSION['login'].'![<a href="logout.php">Wyloguj się !</a>]</p>';
        echo "<p>Twój stan konta wynosi  ".$_SESSION['value']." smoczych monet";  

    ?>
        <form action="obstaw.php" method="post" >
            Ile chcesz obstawić?<br /> <input type="number" name="obstawione" /> <br/>
            Na co chesz obstawic<br />
            <br />CT<input type="checkbox" name="ct" /> <br/>
            <br />TT<input type="checkbox" name="tt" 
            /> <br/>
            <input type="submit" value="Obstaw!" />
        
            
            
             
             
        </form>
</body>
</html>