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
        if($_POST['obstawione']>0)
            
        {
            if($_POST['obstawione']<$_SESSION['value'])
            {
        
            $wylosowana = rand(1,2);
            if((isset($_POST['ct'])) && (!isset($_POST['tt'])))
            {   //Obstwaione na ct
                $wybrana = 1;            
                    if($wybrana==$wylosowana)
                    {
                        //Ktos wygrał
                        $wygrana = $_POST['obstawione'];                        
                        $id=$_SESSION['id'];
                        if ($rezultat = @$polaczenie->query(sprintf(" SELECT * FROM `Users` WHERE `id` = $id ")))
                        {
                            $ile_userow= $rezultat->num_rows;
                            if($rezultat>0)
                            {
                                $do_zapisu = $_SESSION['value'] + $wygrana;
                                if ($rezultat = @$polaczenie->query(sprintf("UPDATE `Users` SET `value` = $do_zapisu WHERE `Users`.`id`=$id")))
                                { 
                                $wyswietlana = $wygrana + $wygrana;
                                $_SESSION['wynik'] = "Wygrałeś ".$wyswietlana." Monet";
                                $polaczenie->close();
                                header('Location: logout.php');
                                }
                                else
                                {
                                    echo "Cos poszło nie tak";
                                }
                            }
                            else
                            {
                                echo "Coś poszło nie tak";
                                $polaczenie->close();
                            }
                        }

                    }
                    else 
                    {
                        //Ktos przegral
                        $wygrana = $_POST['obstawione'];                        
                        $id=$_SESSION['id'];
                        if ($rezultat = @$polaczenie->query(sprintf(" SELECT * FROM `Users` WHERE `id` = $id ")))
                        {
                            $ile_userow= $rezultat->num_rows;
                            if($rezultat>0)
                            {
                                $do_zapisu = $_SESSION['value'] - $wygrana;
                                if ($rezultat = @$polaczenie->query(sprintf("UPDATE `Users` SET `value` = $do_zapisu WHERE `Users`.`id`=$id")))
                                {                                
                                $_SESSION['wynik'] = "Przegrales ".$wygrana." Monet";
                                $polaczenie->close();
                                header('Location: logout.php');
                                }
                                else
                                {
                                    echo "Cos poszło nie tak";
                                }
                            }
                            else
                            {
                                echo "Coś poszło nie tak";
                                $polaczenie->close();
                            }
                        }

                    }
            }
            else
            {
                if((!isset($_POST['ct'])) && (isset($_POST['tt'])))
                {  
                    //obstawione na tt                
                    $wybrana =2;            
                    if($wybrana==$wylosowana)
                    {
                        //Ktos wygrał  
                        $wygrana = $_POST['obstawione'];
                        
                        $id=$_SESSION['id'];
                        if ($rezultat = @$polaczenie->query(sprintf(" SELECT * FROM `Users` WHERE `id` = $id ")))
                        {
                            $ile_userow= $rezultat->num_rows;
                            if($rezultat>0)
                            {
                                $do_zapisu = $_SESSION['value'] + $wygrana;
                                if ($rezultat = @$polaczenie->query(sprintf("UPDATE `Users` SET `value` = $do_zapisu WHERE `Users`.`id`=$id")))
                                {
                                $wyswietlana = $wygrana + $wygrana;
                                $_SESSION['wynik'] = "Wygrałeś ".$wyswietlana." Monet";
                                $polaczenie->close();
                                header('Location: logout.php');
                                }
                                else
                                {
                                    echo "Cos poszło nie tak";
                                }
                            }
                            else
                            {
                                echo "Coś poszło nie tak";
                                $polaczenie->close();
                            }
                        }

                    }
                    else 
                    {
                        //Ktos przegral
                        $wygrana = $_POST['obstawione'];
                        
                        $id=$_SESSION['id'];
                        if ($rezultat = @$polaczenie->query(sprintf(" SELECT * FROM `Users` WHERE `id` = $id ")))
                        {
                            $ile_userow= $rezultat->num_rows;
                            if($rezultat>0)
                            {
                                $do_zapisu = $_SESSION['value'] - $wygrana;
                                if ($rezultat = @$polaczenie->query(sprintf("UPDATE `Users` SET `value` = $do_zapisu WHERE `Users`.`id`=$id")))
                                {
                                $_SESSION['wynik'] = "Przegrales ".$wygrana." Monet";
                                $polaczenie->close();
                                header('Location: logout.php');
                                }
                                else
                                {
                                    echo "Cos poszło nie tak";
                                }
                            }
                            else
                            {
                                echo "Coś poszło nie tak";
                                $polaczenie->close();
                            }
                        }

                    }
                }
                else
                {   $polaczenie->close();
                    $_SESSION['blaad']='<span style="color:red">Możesz zaznaczyć tylko jedną możliwość!</span>';
                    header('Location: index.php');
                }

            }


            $polaczenie->close();
            }
            else
            {   $polaczenie->close();
                $_SESSION['blaad']='<span style="color:red">Nie masz tyle pieniędzy!</span>';
                header('Location: index.php');
            }
        }
        else
        {   $polaczenie->close();
            $_SESSION['blaad']='<span style="color:red">Musisz coś obstawić!</span>';
            header('Location: index.php');
        }
    }
      
    }


    
?>