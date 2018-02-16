<?php   
    session_start();
    
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
        
    $sql= "SELECT * FROM `Users` WHERE `login`='$login' AND `password`='$haslo'";
    if ($rezultat = @$polaczenie->query($sql))
    {
        $ile_userow= $rezultat->num_rows;
            if($ile_userow>0)
            {
                $_SESSION['zalogowany'] = true;
              $wiersz = $rezultat->fetch_assoc();
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
        

        
        
        $polaczenie->close();
    }
        


?>