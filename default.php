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
  session_start();

  if(isset($_REQUEST['logout'])){
    unset($_SESSION['name']);
  }

  if (!isset($_REQUEST['name']) && !isset($_SESSION['name'])) {
    echo "Je ne connais pas votre nom. ";
    echo '<form action="">Nom: <input type="text" name="name"><input type="submit"></form>';
  }else{
    if (isset($_REQUEST['name']) && !isset($_SESSION['name'])) {
      $_SESSION['name']=$_REQUEST['name'];
      $_SESSION['soldiers']=100;
      $_SESSION['gold']=500;
   }
    $name = $_SESSION['name'];
    $soldiers = $_SESSION['soldiers'];
    $gold = $_SESSION['gold'];
    if (isset($_REQUEST['ennemi'])) {
      if ($_SESSION['soldiers']==0) {
        echo "Vous n'avez aucun soldat !";
      }else{
        $ennemisoldiers = $_REQUEST['ennemisoldiers'];
        $ratio = $ennemisoldiers/$soldiers;
        $pertes = rand(0,2*$ratio*$ennemisoldiers);
        $_SESSION['soldiers'] -= $pertes;
        if($_SESSION['soldiers']<0){
          $_SESSION['soldiers']=0;
        }
        if ($pertes > 0.75*$soldiers){
          echo "Vos soldats battent en retraite !<BR>";
        }else{
          echo "L'armée ennemie est défaite et vous pillez $ennemisoldiers pièces d'or. <BR>";
          $_SESSION['gold'] += $ennemisoldiers;
          $gold = $_SESSION['gold'];
        }
        $soldiers = $_SESSION['soldiers'];
      }
      echo "<hr>";
    }
    if (isset($_REQUEST['recruter'])) {
      $recruter = $_REQUEST['recruter'];
      if( $recruter <= 0 ){
        echo "Votre recrutement doit concerner au moins un soldat. ";
      }else if ( $_SESSION['gold'] < 3*$recruter ){
        echo "Vous n'avez pas assez d'or. ";
      }else{
        $_SESSION['gold'] = $_SESSION['gold'] - 3*$recruter;
        $_SESSION['soldiers'] += $recruter;
        echo "$recruter soldats recrut&eacute;(s)<BR>";
      }
      echo "<hr>";
    }
    echo "Votre nom est $name. <a href=\"".$_SERVER['PHP_SELF']."?logout=1\">Se déconnecter</a><br>";
    echo "Vous avez ".$_SESSION['gold']." pi&egrave;ces d'or. <br>";
    echo "Vous avez ".$_SESSION['soldiers']." soldats. <br>";
    echo "<br>";
    for ($i=1 ; $i<6 ; $i++){
      $ns = rand(1,200);
      echo "Ennemi $i : $ns soldats <form action=\"\"><input type=hidden name=ennemi value=$i><input type=hidden name=ennemisoldiers value=$ns><input type=submit value=\"Attaquer\"></form>";
    }
    echo "<hr>Recruter <form action=\"\"><input type=\"text\" name=\"recruter\"> soldats (3 po/soldat) <input type=\"submit\" value=\"Recruter\"></form>";
  }
?>

</body>

</HTML>
