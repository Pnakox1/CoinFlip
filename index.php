<?php 
session_start();
   if ((isset($_SESSION['zalogowany'])))
	{
		header('Location: gra.php');
		exit();
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
       <b> Bogaci będa biednymi - Przemek 2k18 </b>
    <form action="zaloguj.php" method="post" >
    <input type="text" name="login" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" /> 
    <input type="password" name="haslo" placeholder="Haslo" onfocus="this.placeholder=''" onblur="this.placeholder='Haslo'"  /> 
    <input type="submit" value="Zaloguj się!" />
   <a href="rejestracja.php">           Zarejestruj się!     </a>
   <a href="https://steamcommunity.com/tradeoffer/new/?partner=97288835&token=eJe8Dw-j">           Depozyt     </a>
    
    </form>
    </div>
    <?php 
        if(isset($_SESSION['blad']))
            echo $_SESSION['blad'];
    ?>
    
    
</body>
</html>