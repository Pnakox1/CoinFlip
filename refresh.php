<?php   
    session_start();
    
    if(1==2)
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
        $login=$_SESSION['login'];
        $haslo=$_SESSION['haslo'];
        


    if ($rezultat = @$polaczenie->query(sprintf("SELECT * FROM `Users` WHERE `login`=$login ")));
       
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
        

        
        
        $polaczenie->close();
    }
        


?>