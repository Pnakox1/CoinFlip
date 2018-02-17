<?php   
    session_start();
    
    if (!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }

require_once "connect.php" ;
    $polaczenie= @new mysqli($host,$db_user,$db_password,$db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error".$polaczenie->connect_errno;
    }
    else
    {
        
    }
    $login=$_SESSION['login'];
    if ($rezultat = @$polaczenie->query(sprintf("SELECT * FROM `Users` WHERE `login`=$login")))       
    {
        $ile_userow= $rezultat->num_rows;
            if($ile_userow>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                if(password_verify($haslo,$wiersz['password']))
                {
                $_SESSION['zalogowany'] = true;             
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['login'] = $wiersz['login'];           
                $_SESSION['value'] = $wiersz['value'];                         
                $rezultat->close();
                header('Location:index.php');
                }
            }
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> 
    <title>CoinFlip</title>
    <link rel="stylesheet" href="http://pnakox.cba.pl/style.css" type="text/css" /> 
</head>
<body>
    <div id="container">
    <?php 
        echo "<p>Witaj ".$_SESSION['login'].'![<a href="logout.php">Wyloguj się !</a>]</p>';
        echo "<p>Twój stan konta wynosi  ".$_SESSION['value']." smoczych monet";  

    ?>
    
        <form action="obstaw.php" method="post" >
            Ile chcesz obstawić?<br /> <input type="number" name="obstawione" /> <br/>
            Na co chesz obstawic<br />
            <br />CT<input type="checkbox" name="ct" value="1" /> <br/>
            <br />TT<input type="checkbox" name="tt" 
            value="2"/> <br/>
            <?php
                if(isset($_SESSION['blaad']))
                {
                    echo $_SESSION['blaad'];
                    unset($_SESSION['blaad']);
                } 
                if(isset($_SESSION['wynik']))
                {
                    echo $_SESSION['wynik'];
                    unset($_SESSION['wynik']);
                    
                }
            ?>
            <br />
            <input type="submit" value="Obstaw!" />       
        
            
            
             
             
        </form>
        </div>
</body>
</html>