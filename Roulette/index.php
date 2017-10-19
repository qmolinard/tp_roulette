<?php
session_start();

if(isset($_SESSION['nom']))
{
	header("Location:roulette.php");
}
?>
<!DOCTYPE html>
<?php
//Step1
 $db = mysqli_connect('localhost','slam_user','1234','SLAM')
 or die('Error connecting to MySQL server.');
?>
<?php
$remplir=0;
if(isset($_POST['Login']))
{
	// Vérification des identifiants
	$bdd = new PDO(
		'mysql:host=localhost; dbname=SLAM;charset=utf8',
		'slam_user',
		'1234'
	);
	//$req = $bdd->query('SELECT identifiant FROM joueur WHERE nom = molinard AND motdepasse = mecanos');
	$req = $bdd->query('SELECT * FROM joueur');

	$resultat = $req->fetch();

	if($_POST['id']==$resultat['nom']&&$_POST['mdp']==$resultat['motdepasse'])
	{
		//if (!$resultat)
		//{
		//	echo 'Mauvais identifiant ou mot de passe !';
			// affich form 
		//}
		//else
		//{
			
			$_SESSION['identifiant'] = $resultat['identifiant'];
			$_SESSION['nom'] = $resultat['nom'];
			$_SESSION['argent'] = $resultat['argent'];
			echo 'Vous êtes connecté !';
			header("Location:roulette.php");
		//}
	}
	else
	{
		$remplir=1;
	}
}

if(isset($_POST['Inscription']))
{
	header("Location:inscription.php");
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	
	<style>
	.alert {
	text-align:center;
	}
	
	.container {
	width:500px;
	margin: auto;
	}

	#bouton {
		margin: auto;
	}
	
    </style>
	
  </head>
  <body>
	<div class="alert alert-primary" role="alert">
    <h2>La roulette</h2>
	</div>
	
	<div class="alert alert-warning" role="alert">
	<h3>Connectez-vous pour jouer</h3>
	</div>

	<?php
	if($remplir==1)
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<h3>Identifiant ou mot de passe incorrect</h3>';
		echo '</div>';
		$remplir=0;
	}
	?>
	
	<div class="container">
  <form method="post">
    <div class="form-group row">
      <!-- <label for="inputIdentifiant3" class="col-sm-2 col-form-label" >Identifiant</label> -->
      <div class="col-sm-10">
        <input type="identifiant" class="form-control" id="inputIdentifiant3" placeholder="Identifiant" name="id">
      </div>
    </div>
    <div class="form-group row">
      <!--<label for="inputPassword3" class="col-sm-2 col-form-label" >Mot de passe</label> -->
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe" name="mdp">
      </div>
    </div>
    <div class="form-group row">
		<button id="bouton" type="reset" class="btn btn-warning" name="Effacer">Effacer</button>
        <button id="bouton" type="submit" class="btn btn-primary" name="Login">Login</button>
		<button id="bouton" type="submit" class="btn btn-info" name="Inscription">Inscription</button>
    </div>
  </form>
</div>
	
  </body>
</html>

