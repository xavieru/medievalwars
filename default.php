<?php 
require_once "player_data.php";
require_once "configuration_jeu.php";
 ?>

<HTML>

<head>
<title>Medieval Wars - un jeu de strat&eacute;gie m&eacute;di&eacute;vale</title>
<style type="text/css">
  <?php include 'css/style.css'; ?>
</style>
</head>

<body>
<h1 align=center>Medieval Wars</h1>
<hr>

<?php

  //session_start();

  if(isset($_REQUEST['logout'])){
    unset($_SESSION['name']);
  }

  if (/*!isset($_REQUEST['name']) &&*/ !isset($_SESSION['name'])) {
    echo "Je ne connais pas votre nom. ";
    //echo '<form action="">Nom: <input type="text" name="name"><input type="submit"></form>';
    echo '<a href="connect.php">Se connecter</a>';
  }else{
    /*if (isset($_REQUEST['name']) && !isset($_SESSION['name'])) {
      $_SESSION['name']=$_REQUEST['name'];
      $_SESSION['soldiers']=100;
      $_SESSION['gold']=500;
    }*/
    $name = $_SESSION['name'];
    if (isset($_REQUEST['ennemi'])) {
      $soldiers = get_soldiers();
      if ($soldiers==0) {
        echo "Vous n'avez aucun soldat !";
      }else{
        $ennemisoldiers = $_REQUEST['ennemisoldiers'];
        $ratio = $ennemisoldiers/$soldiers;
        $pertes = rand(0,2*$ratio*$ennemisoldiers);
        if($pertes > $ratioretraite*$soldiers){
          $pertes = $ratioretraite*$soldiers;
        }
        sub_soldiers($pertes);
        if ($pertes >= $ratioretraite*$soldiers){
          echo "Vos soldats battent en retraite !<BR>";
        }else{
          echo "L'armée ennemie est défaite et vous pillez $ennemisoldiers pièces d'or. <BR>";
          add_gold( $ennemisoldiers * $ratiopillage );
        }
      }
      echo "<hr>";
    }
    if (isset($_REQUEST['recruter'])) {
      $recruter = $_REQUEST['recruter'];
      if( $recruter <= 0 ){
        echo "Votre recrutement doit concerner au moins un soldat. ";
      }else if ( sub_gold($costsoldier*$recruter) ){
      //  echo "Vous n'avez pas assez d'or. ";
      //}else{
        //$_SESSION['gold'] = $_SESSION['gold'] - 3*$recruter;
        add_soldiers($recruter);
        echo "$recruter soldats recrut&eacute;(s)<BR>";
      }
      echo "<hr>";
    }
    echo "Votre nom est $name. <a href=\"".$_SERVER['PHP_SELF']."?logout=1\">Se déconnecter</a><br>";
    echo "Vous avez ".get_gold()." pi&egrave;ces d'or. <br>";
    echo "Vous avez ".get_soldiers()." soldats. <br>";
    echo "<br>";
    for ($i=1 ; $i<6 ; $i++){
      $ns = rand(1,200);
      echo "Ennemi $i : $ns soldats <form action=\"\"><input type=hidden name=ennemi value=$i><input type=hidden name=ennemisoldiers value=$ns><input type=submit value=\"Attaquer\"></form>";
    }
    echo "<hr>Recruter <form action=\"\"><input type=\"text\" name=\"recruter\"> soldats ($costsoldier po/soldat) <input type=\"submit\" value=\"Recruter\"></form>";
  }
?>

</body>

</HTML>
