<?php   
    session_start();
    
    if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
    {
        header('Location: index.php');
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
        $login=$_POST['login'];
        $haslo=$_POST['haslo'];
        $_SESSION['login'] = $login;
        $_SESSION['haslo'] = $haslo;
        


    if ($rezultat = @$polaczenie->query(sprintf("SELECT * FROM `Users` WHERE `login`='%s'",
        mysqli_real_escape_string($polaczenie,$login))));
       
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
                unset($_SESSION['blad']);
                
                    
                    
                $rezultat->close();
                header('Location:gra.php');
                }
                    else
                    {
                   $_SESSION['blad']='<span style="color:red">Nieprawidlowy login lub haslo! </span>';
                   header('Location: index.php');
                    }
            }
            else
            {
               $_SESSION['blad']='<span style="color:red">Nieprawidlowy login lub haslo! </span>';
               header('Location: index.php');
            }
    }
        

        
        
        $polaczenie->close();
    }
        


?>