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
$testchamps=0;
if(isset($_POST['Valider']))
{
	// Vérification des identifiants
	$bdd = new PDO(
		'mysql:host=localhost; dbname=SLAM;charset=utf8',
		'slam_user',
		'1234'
	);
	
	if($_POST['id']!=null && $_POST['mdp']!=null && $_POST['checkmdp']!=null)
	{			
		if($_POST['mdp']==$_POST['checkmdp'])
		{
			$bdd->query('INSERT INTO joueur VALUES(NULL, "'.$_POST['id'].'", "'.$_POST['mdp'].'", 1000);');
			$_SESSION['nom'] = $_POST['id'];
			$_SESSION['argent'] = 1000;
			header("Location:roulette.php");
		}
		else
		{
			$testchamps=2;
		}
	}
	else
	{
		$testchamps=1;
	}
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
	<h3>Inscription</h3>
	</div>

	<?php
	if($testchamps==1)
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<h3>Veuillez remplir les champs</h3>';
		echo '</div>';
		$testchamps=0;
	}
	if($testchamps==2)
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<h3>Mot de passe incorrect</h3>';
		echo '</div>';
		$testchamps=0;
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
      <!--<label for="inputPassword3" class="col-sm-2 col-form-label" >Mot de passe</label> -->
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword4" placeholder="Confirmer mot de passe" name="checkmdp">
      </div>
    </div>
    <div class="form-group row">
        <button id="bouton" type="submit" class="btn btn-primary" name="Valider">Valider</button>
    </div>
  </form>
</div>
	
  </body>
</html>