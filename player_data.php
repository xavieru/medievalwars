<?php
require_once 'sql_connect.php';
session_start();

function get_gold() {
	$sql = "SELECT gold FROM Joueurs WHERE id=".$_SESSION['id'];
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant get_gold.'; 
        } 
        else 
        { 
        	if(mysql_num_rows($result) == 0) 
                { 
                    echo 'Aucun joueur de cet id.'; 
                } 
                else 
                { 
                    while($row = mysql_fetch_assoc($result)) 
                    { 
                        return $row['gold']; 
		    }
		}
	} 
	return 0;
}

function set_gold($newgold) {
	$sql = "UPDATE Joueurs SET gold=$newgold";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant set_gold.'; 
        } 
}

function add_gold($addgold) {
	$newgold = get_gold() + $addgold;
	set_gold($newgold);
}

function sub_gold($cost) {
	$gold = get_gold();
	if ( $gold < $cost ) {
		echo "Vous n'avez pas assez d'or. ";
		return false;
	}else{
		add_gold(-$cost);
		return true;
	}
}

function get_soldiers() {
	$sql = "SELECT soldiers FROM Joueurs WHERE id=".$_SESSION['id'];
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant get_soldiers.'; 
        } 
        else 
        { 
        	if(mysql_num_rows($result) == 0) 
                { 
                    echo 'Aucun joueur de cet id.'; 
                } 
                else 
                { 
                    while($row = mysql_fetch_assoc($result)) 
                    { 
                        return $row['soldiers']; 
		    }
		}
	} 
	return 0;
}

function set_soldiers($newsoldiers) {
	$sql = "UPDATE Joueurs SET soldiers=$newsoldiers";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant set_soldiers.'; 
        } 
}

function add_soldiers($addsoldiers) {
	$newsoldiers = get_soldiers() + $addsoldiers;
	set_soldiers($newsoldiers);
}

function sub_soldiers($pertes) {
	$soldiers = get_soldiers();
	if ( $soldiers < $pertes ) {
		set_soldiers(0);
	}else{
		add_soldiers(-$pertes);
	}
}

?>
