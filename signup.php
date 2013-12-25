<?php
require_once 'sql_connect.php';
require_once 'configuration_jeu.php';
require_once "outils.php";
session_start();

function disp_form()
{
        echo '<form method="post" action="">  
		Nom: <input type="text" name="name" />  <BR>
                Mot de passe: <input type="password" name="password" /> <BR> 
                Répétez le mot de passe: <input type="password" name="password_check" /> <BR> 
	    <input type="submit" value="S\'inscrire" />  
         </form>'; 
}

   echo '<h3>S\'inscrire</h3>';  

    if($_SERVER['REQUEST_METHOD'] != 'POST')  
    {  
	    disp_form();
    } 
    else 
    { 
        $errors = array();   
          
        if(!isset($_POST['name']) || $_POST['name']=="" )  
        {  
            echo 'Le champ nom du formulaire ne doit pas être vide.';  
	    disp_form();
        }  
	else if(!ctype_alnum($_POST['name']))  
        {  
            echo 'Le nom du joueur ne doit comporter que des lettres et des chiffres. ';  
	    disp_form();
        }  
	else if(strlen($_POST['name']) > 30)  
        {  
            echo 'Le nom ne peut pqs faire plus de 30 caractères.';  
	    disp_form();
	}
	else if(!isset($_POST['password']) || $_POST['password']=="" )  
        {  
            echo 'Le champ mot de passe du formulaire ne doit pas être vide.';  
	    disp_form();
        }  
	else if(strlen($_POST['password']) > 30)  
        {  
            echo 'Le mot de passe ne peut pas faire plus de 30 caractères.';  
	    disp_form();
	}
	else if($_POST['password']!=$_POST['password_check']){
		echo 'Les mots de passe doivent correspondre. ';
	    disp_form();
	}
	else 
	{
		list($posx, $posy) = get_free_pos();	
            $sql = "INSERT INTO Joueurs(name,password,gold,soldiers,posx,posy) VALUES('" . mysql_real_escape_string($_POST['name'])."','".sha1($_POST['password']). "', ".STARTGOLD." , ".STARTSOLDIERS.", $posx, $posy)"; 
                          
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

