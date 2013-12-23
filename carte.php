<?php 
require_once 'configuration_jeu.php';
require_once 'outils.php';
require_once 'attack.php';

if(isset($_REQUEST['attack'])) {
  attaquer($_REQUEST['attack']);
}

echo "<table border=0>";

for ($y=MINCARTE;$y<=MAXCARTE;$y++){
  echo "<tr>";
  for ($x=MINCARTE;$x<=MAXCARTE;$x++){
	  $joueur_id = joueur_sur($x,$y);
	  $opt = "";
	  if($joueur_id != -1){
		  $fname = "carte_chateau.png";
		  if($_SESSION['id']!=$joueur_id) {
			  $opt="attack=$joueur_id";
		  }
	  }else if ( rand(0,1)<0.5 ){
		$fname = "carte_herbe.png";
	  }else{
		$fname = "carte_foret.png";
	  }
	  echo '<td><a href="'.$_SERVER['PHP_SELF']."?$opt\"><img src=\"img/$fname\"></a>";
  }
  echo "</tr>";
}

echo "</table>";

?>

