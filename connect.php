<?php
require_once 'sql_connect.php';
session_start();

   echo '<h3>Se connecter</h3>';  

    if($_SERVER['REQUEST_METHOD'] != 'POST')  
    {  
        echo '<form method="post" action="">  
            Nom: <input type="text" name="name" />  
            <input type="submit" value="Se connecter" />  
         </form>'; 

        echo '<a href="signup.php">Pas encore inscrit ?</a>';
    } 
    else 
    { 
        $errors = array();   
          
        if(!isset($_POST['name']))  
        {  
            echo 'Le champ nom du formulaire ne doit pas être vide.';  
        }  
        else 
        { 
            $sql = "SELECT  
                        id, 
                        name 
                    FROM 
                        Joueurs 
                    WHERE 
                        name = '" . mysql_real_escape_string($_POST['name']) . "'"; 
                          
            $result = mysql_query($sql);  
            if(!$result)  
            {  
                echo 'Erreur pendant la connexion.'; 
            } 
            else 
            { 
                if(mysql_num_rows($result) == 0) 
                { 
                    echo 'Aucun joueur de ce nom.'; 
                } 
                else 
                { 
                    $_SESSION['signed_in'] = true; 
                     
                    while($row = mysql_fetch_assoc($result)) 
                    { 
                        $_SESSION['id']    = $row['id']; 
                        $_SESSION['name']  = $row['name']; 
                    } 
                     
                    echo 'Bienvenue, ' . $_SESSION['name'] . '. <a href="default.php">Entrer dans le jeu</a>.'; 
                    header("Location: default.php");
                } /* non-empty result */ 
            } /* valid result */
        } /* correct form */ 
    } /* method POST */ 

?>

