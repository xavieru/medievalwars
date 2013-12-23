<?php
require_once 'sql_connect.php';
require_once 'configuration_jeu.php';
session_start();

function get_free_pos() {
	$found = 0;
	$i = 0;
	$cutoff = 10*(MAXCARTE-MINCARTE)*(MAXCARTE-MINCARTE);
  while( $found == 0 && $i < $cutoff ) {
	$posx = rand(MINCARTE,MAXCARTE);
	$posy = rand(MINCARTE,MAXCARTE);
	$sql = "SELECT id FROM Joueurs WHERE posx=$posx AND posy=$posy";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant get_free_pos.'; 
        } 
        else 
        { 
        	if(mysql_num_rows($result) == 0) 
		{ 
			$found = 1;
		    return array($posx,$posy);
                } 
	} 
	$i++;
  }
  echo "Attention ! Aucun emplacement trouvé ! <BR>";
  return array(0,0);
}

function joueur_sur($posx,$posy) {
	$sql = "SELECT id FROM Joueurs WHERE posx=$posx AND posy=$posy";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant get_free_pos.'; 
        } 
        else 
        { 
		if(mysql_num_rows($result) == 0) {
			return -1;
		}else{
                 	$row = mysql_fetch_assoc($result); 
			return $row['id'];
		}
	}
	return -1;
}

?>
