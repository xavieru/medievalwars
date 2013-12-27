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

function get_soldiers($id = -1) {
	if($id==-1){$id=$_SESSION['id'];}
	$sql = "SELECT soldiers FROM Joueurs WHERE id=$id";
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

function set_soldiers($newsoldiers, $id=-1) {
	if($id==-1){$id=$_SESSION['id'];}
	$sql = "UPDATE Joueurs SET soldiers=$newsoldiers WHERE $id=id";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant set_soldiers.'; 
        } 
}

function add_soldiers($addsoldiers, $id=-1) {
	$newsoldiers = get_soldiers($id) + $addsoldiers;
	set_soldiers($newsoldiers,$id);
}

function sub_soldiers($pertes,$id=-1) {
	$soldiers = get_soldiers($id);
	if ( $soldiers < $pertes ) {
		set_soldiers(0);
	}else{
		add_soldiers(-$pertes,$id);
	}
}

function get_officers($id = -1) {
	if($id==-1){$id=$_SESSION['id'];}
	$sql = "SELECT officers FROM Joueurs WHERE id=$id";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant get_officers.'; 
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
                        return $row['officers']; 
		    }
		}
	} 
	return 0;
}

function set_officers($newofficers, $id=-1) {
	if($id==-1){$id=$_SESSION['id'];}
	$sql = "UPDATE Joueurs SET officers=$newofficers WHERE $id=id";
	$result = mysql_query($sql);  
        if(!$result)  
        {  
        	echo 'Erreur MySQL pendant set_officers.'; 
        } 
}

function add_officers($addofficers, $id=-1) {
	$newofficers = get_officers($id) + $addofficers;
	set_officers($newofficers,$id);
}

function sub_officers($pertes,$id=-1) {
	$officers = get_officers($id);
	if ( $officers < $pertes ) {
		set_officers(0);
	}else{
		add_officers(-$pertes,$id);
	}
}

?>
