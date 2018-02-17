<?php
session_start();

if((!isset($_POST['obstawione'])) && ($_SESSION['value']<$_POST['obstawione']))
    {
        header('Location: index.php');
        exit();
    }  
else{
    require_once "connect.php" ;
        $polaczenie= @new mysqli($host,$db_user,$db_password,$db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error".$polaczenie->connect_errno;
    }
    else
    {
        
            if((isset($_POST['ct'])) || (isset($_POST['tt'])))
            {
                $wylosowana=rand(1,2);
                if(isset($_POST['ct']))
                {
                    $ct=1;
                    if($wylosowana==$ct)
                    {

                             if ($rezultat = @$polaczenie->query(sprintf("SELECT * FROM 'Users' WHERE 'login=$login' AND 'value=$value'")))      
                            {
                                $ile_userow= $rezultat->num_rows;
                                if($ile_userow>0)
                                {
                                            echo "Udało sie ";
                                             echo "WYGRALES";                       
                                            $ile_wygral=$_POST['obstawione']+$_POST['obstawione'];
                                            echo $ile_wygral;
                                            $login=$_SESSION['login'];
                                            $value=$_SESSION['value'];
                                }
                                else
                                {
                                    echo "Zjebało sie ";
                                    
                                }                               

                            }
                   
                
                else
                {
                    $tt=2;
                    if($wylosowana==$tt)
                    {
                        echo "WYGRALES";
                        $ile_wygral=$_POST['obstawione']+$_POST['obstawione'];
                        echo $ile_wygral;
                    }
                    else
                    {
                        echo "PRZEGRALES";
                       echo $_POST['obstawione'];
                    }
                    
                }
                
            }
            else
            {
                header('Location:gra.php');
            }
        
    }
                                 }
                                 }
}

    
?>