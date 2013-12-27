<?php
require_once 'sql_connect.php';
require_once 'configuration_jeu.php';
require_once 'player_data.php';
session_start();

function attaquer($ennemi_id) {
	$soldiers = get_soldiers();
	$ennemisoldiers = get_soldiers($ennemi_id);
	$officers = get_officers();
	$ennemiofficers = get_officers($ennemi_id);
      if ($soldiers==0 && $officers==0) {
        echo "Vous n'avez aucune troupe !";
      }else{
	if($officers > OFFICERRATIO*$soldiers)
	{
		$power = $soldiers*(1+BONUSOFFICER)+OFFICERPOWER*$officers;
	}else{
		$power = $soldiers + BONUSOFFICER*($officers/OFFICERRATIO)+OFFICERPOWER*$officers;
	}
	if($ennemiofficers > OFFICERRATIO*$ennemisoldiers)
	{
		$epower = $ennemisoldiers*(1+BONUSOFFICER)+OFFICERPOWER*$ennemiofficers;
	}else{
		$epower = $ennemisoldiers + BONUSOFFICER*($ennemiofficers/OFFICERRATIO)+OFFICERPOWER*$ennemiofficers;
	}
        $ratio = AVANTAGE_DEFENSEUR*$epower/$power;
	$pertes = MIN( rand(0 , 2*$ratio*$epower) , RATIORETRAITE*$soldiers);
	if($ennemisoldiers==0)
		$pertes_ennemi=0;
	else
        	$pertes_ennemi = MIN( rand(0 , 2/$ratio*$power) , RATIORETRAITE*$ennemisoldiers);
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

function attaquer_barbares($ennemisoldiers) {
	$soldiers = get_soldiers();
	$officers = get_officers();
	$ennemiofficers = 0;
      if ($soldiers==0 && $officers==0) {
        echo "Vous n'avez aucune troupe !";
      }else{
	if($officers > OFFICERRATIO*$soldiers)
	{
		$power = $soldiers*(1+BONUSOFFICER)+OFFICERPOWER*$officers;
	}else{
		$power = $soldiers + BONUSOFFICER*($officers/OFFICERRATIO)+OFFICERPOWER*$officers;
	}
	if($ennemiofficers > OFFICERRATIO*$ennemisoldiers)
	{
		$epower = $ennemisoldiers*(1+BONUSOFFICER)+OFFICERPOWER*$ennemiofficers;
	}else{
		$epower = $ennemisoldiers + BONUSOFFICER*($ennemiofficers/OFFICERRATIO)+OFFICERPOWER*$ennemiofficers;
	}
        $ratio = AVANTAGE_DEFENSEUR*$epower/$power;
	$pertes = MIN( rand(0 , 2*$ratio*$epower) , RATIORETRAITE*$soldiers);
	/*if($ennemisoldiers==0)
		$pertes_ennemi=0;
	else
		$pertes_ennemi = MIN( rand(0 , 2/$ratio*$power) , RATIORETRAITE*$ennemisoldiers);*/
        sub_soldiers($pertes);
        //sub_soldiers($pertes_ennemi,$ennemi_id);
        if ($pertes >= RATIORETRAITE*$soldiers){
          echo "Vos soldats battent en retraite !<BR>";
        }else{
          echo "L'armée ennemie est défaite et vous pillez $ennemisoldiers pièces d'or. <BR>";
          add_gold( $ennemisoldiers * RATIOPILLAGE );
        }
      }
	
}


?>

