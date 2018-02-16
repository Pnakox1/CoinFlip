<?php 
    session_start();
    
    if(isset($_POST['email']))
    {   //Udana walidacja danych
        $wszystko_OK=true;
        //Sprawdzienie nickname
        $nick=$_POST['nick'];        
        //Sprawdzenie długosi nicku
        if((strlen($nick)<3) || (strlen($nick)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']= "Nick musi zawierać od 3 do 20 znaków";
        }
        //Sprawdzenie składu nicku 
        if(ctype_alnum($nick)==false)
        {
            $wszystko_OK = false;
            $_SESSION['e_nick']="Nick może składac sie tylko ze znaków alfanumerycznych.";
        }
        //Sprawdzenie poprawnosci emaila
        $email = $_POST['email'];
        $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
        //Email został zmieniony
        if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) ||
          ($emailB!=$email))
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Sprawdz poprawnosc adresu email";
        }
        //Sprawdz poprwnosc hasla
        $haslo1=$_POST['haslo1'];
        $haslo2=$_POST['haslo2'];
        //Haslo za krótkie/długie
        if((strlen($haslo1)<8 ||(strlen($haslo1)>20) ))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Haslo musi zawierac od 8 od 20 znaków";
        }
        //podane hasla sa różne
        if($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Wpisanie hasła różnią sie od siebie!";
            
        }
        //Szyfrowanie hasla
        $haslo_hash= password_hash($haslo1,PASSWORD_DEFAULT);
        
        //Sprawdzanie regulaminu
        if(!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Musisz zaakceptowac regulamin!";
            
        }
        
        //Bot or not?
		$sekret = "6Lf6ykYUAAAAAPqYS6OGU3VIGwzXAghWrdlLXY3v";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
        
        require_once"connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $polaczenie= new mysqli($host,$db_user,$db_password,$db_name);
            if($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else            
            {
                //czy email jest w bazie
                $rezultat = $polaczenie->query("SELECT id FROM Users WHERE
                mail='$email'");
                if(!rezultat) throw new Exception($polaczenie->error);
                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0)
                {
                $wszystko_OK=false;
                $_SESSION['e_email']="Podany adres e-mail jest zajęty!";
                }
                
                //czy nick jest juz w bazie
                $rezultat = $polaczenie->query("SELECT id FROM Users WHERE
                login='$nick'");
                if(!rezultat) throw new Exception($polaczenie->error);
                $ile_takich_nickow = $rezultat->num_rows;
                if($ile_takich_nickow>0)
                {
                $wszystko_OK=false;
                $_SESSION['e_nick']="Podany nick jest zajęty!";
                }
                
                //Wszystko sie udało 
                if($wszystko_OK==true)
                {
                    if($polaczenie->query("INSERT INTO Users VALUES(NULL,'$nick','$haslo_hash',100,'$email') "))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }
                
                
                $polaczenie->close();
            }
            
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">błąd serwera!"</span>';
            echo '<br /> <br />'.$e;
        }
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}    
  
    }

    
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" /> 
    <title>CoinFlip-Rejestracja</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
         .error
        {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form method="post">
        Nickname:<br /> <input type="text" name="nick" /> <br />
        
        <?php 
            if(isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION[e_nick]);
            }
        ?>
        
        E-mail:<br /> <input type="text" name="email" /> <br />
        
        <?php 
            if(isset($_SESSION['e_email']))
            {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>
        
        
        Twoje haslo:<br /> <input type="password" name="haslo1" /> <br />
        
        <?php 
            //Wyswietlenie błedu
            if(isset($_SESSION['e_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
            }
        ?>
        
        
        
        Powtórz haslo:<br /> <input type="password" name="haslo2" /> <br />        
        
        <label>
        <input type="checkbox" name="regulamin" /> Akceptuję regulamin.
        </label>
        
        <?php 
            //Wyswietlenie błedu
            if(isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>
        
        
        <div class="g-recaptcha" data-sitekey="6Lf6ykYUAAAAAABmqRkzN8zbe_4rZCwmh8oMQbMx"></div>
        <?php 
            //Wyswietlenie błedu
            if(isset($_SESSION['e_bot']))
            {
                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                unset($_SESSION['e_bot']);
            }
        ?>
        
        <br />
        
        <input type="submit" value="Zarejestruj się!" />
    
    
    </form>
</body>
</html>