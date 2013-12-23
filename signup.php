<?php
require_once 'sql_connect.php';
require_once 'configuration_jeu.php';
require_once "outils.php";
session_start();

   echo '<h3>S\'inscrire</h3>';  

    if($_SERVER['REQUEST_METHOD'] != 'POST')  
    {  
        echo '<form method="post" action="">  
            Nom: <input type="text" name="name" />  
            <input type="submit" value="S\'inscrire" />  
         </form>'; 
    } 
    else 
    { 
        $errors = array();   
          
        if(!isset($_POST['name']))  
        {  
            echo 'Le champ nom du formulaire ne doit pas être vide.';  
        }  
	else if(!ctype_alnum($_POST['name']))  
        {  
            echo 'Le nom du joueur ne doit comporter que des lettres et des chiffres. ';  
        }  
	else if(strlen($_POST['name']) > 30)  
        {  
            echo 'Le nom ne peut pqs faire plus de 30 caractères.';  
        }
	else 
	{
		list($posx, $posy) = get_free_pos();	
            $sql = "INSERT INTO Joueurs(name,gold,soldiers,posx,posy) VALUES('" . mysql_real_escape_string($_POST['name']) . "', ".STARTGOLD." , ".STARTSOLDIERS.", $posx, $posy)"; 
                          
            $result = mysql_query($sql);  
            if(!$result)  
            {  
		    echo 'Erreur pendant la connexion. <BR>'; 
		    echo "La requête SQL est : $sql";
            } 
            else 
	    { 
		 /* Joueur créé, on va maintenant aller chercher l'ID */
		 $sql = "SELECT id FROM Joueurs WHERE name='" . mysql_real_escape_string($_POST['name']) . "'";
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
		     $_SESSION['name'] = $_POST['name'];
                   
                     while($row = mysql_fetch_assoc($result)) 
                     { 
                       $_SESSION['id']    = $row['id']; 
		     }
                     echo 'Bienvenue, ' . $_SESSION['name'] . '. <a href="default.php">Entrer dans le jeu</a>.'; 
                     header("Location: default.php");
		   }
	         }
            } /* valid result */
        } /* correct form */ 
    } /* method POST */ 

?>

