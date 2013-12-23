<?php
require_once 'sql_connect.php';
require_once 'configuration_jeu.php';
require_once 'player_data.php';
session_start();

function attaquer($ennemi_id) {
	$soldiers = get_soldiers();
	$ennemisoldiers = get_soldiers($ennemi_id);
      if ($soldiers==0) {
        echo "Vous n'avez aucun soldat !";
      }else{
        $ratio = AVANTAGE_DEFENSEUR*$ennemisoldiers/$soldiers;
	$pertes = MIN( rand(0 , 2*$ratio*$ennemisoldiers) , RATIORETRAITE*$soldiers);
	if($ennemisoldiers==0)
		$pertes_ennemi=0;
	else
        	$pertes_ennemi = MIN( rand(0 , 2/$ratio*$soldiers) , RATIORETRAITE*$ennemisoldiers);
        sub_soldiers($pertes);
        sub_soldiers($pertes_ennemi,$ennemi_id);
        if ($pertes >= RATIORETRAITE*$soldiers){
          echo "Vos soldats battent en retraite !<BR>";
        }else{
          echo "L'armée ennemie est défaite et vous pillez $ennemisoldiers pièces d'or. <BR>";
          add_gold( $ennemisoldiers * RATIOPILLAGE );
        }
      }
	
}

?>

