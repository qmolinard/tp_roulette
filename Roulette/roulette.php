<?php session_start();

if(isset($_SESSION['nom']))
{
}
else
{
	header("Location:index.php");
}
?>
<?php
if(isset($_GET['jouer']))
{	//var_dump($_GET);
	$resultat = rand (1 , 36);
	$perdugagne=0;
	$testparie=0;
	$gain=0;
	if($_GET['mise']!=null && $_GET['mise']<=$_SESSION['argent'] && $_GET['mise']>0)
	{
		$bdd = new PDO(
		'mysql:host=localhost; dbname=SLAM;charset=utf8',
		'slam_user',
		'1234'
		);
		$_SESSION['argent'] -= $_GET['mise'];
		
		if($_GET['nombre']!=null)
		{
			if($_GET['nombre']==$resultat)
			{
				$_SESSION['argent'] += $_GET['mise']*35;
				$gain = $_GET['mise']*35;
				$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
				$perdugagne--;
			}
			
			else
			{
				$perdugagne++;
				$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
			}
		}
		
		//else if($_GET['im_paire']=="impaire" || $_GET['im_paire']=="paire")
		else if(isset($_GET['im_paire']))
		{
			$test=$resultat%2;
			if($test==1 && $_GET['im_paire']=="impaire")
			{
				$_SESSION['argent'] += $_GET['mise']*2;
				$gain = $_GET['mise']*2;
				$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
				$perdugagne--;
			}
			
			else if($test==0 && $_GET['im_paire']=="paire")
			{
				$_SESSION['argent'] += $_GET['mise']*2;
				$gain = $_GET['mise']*2;
				$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
				$perdugagne--;
			}
			
			else
			{
				$perdugagne++;
				$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
			}
		}
		
		else
		{
			$_SESSION['argent'] += $_GET['mise'];
			$testparie=1;
		}
		
		
		$bdd->query('UPDATE joueur SET argent='.$_SESSION['argent'].' WHERE nom="'.$_SESSION['nom'].'";');
		//$bdd->query('INSERT INTO partie VALUES("'.$_SESSION['nom'].'", NOW(), '.$_GET['mise'].', '.$gain.');');
	}
}
if(isset($_GET['quitter']))
{
	unset($_SESSION['nom']);
	header("Location:index.php");
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

	#bouton1 {
		margin: auto;
		background-color: #4CAF50;
	}
	
	#bouton2 {
		margin: auto;
		background-color: red;
	}
	
	.texte {
	text-align: center;
	}
	
    </style>
	
  </head>
	<body>
		<div class="alert alert-primary" role="alert">
		<h2>La roulette</h2>
		</div>
		
		<div class="alert alert-warning" role="alert">
		<?php
		echo '<h3>'.$_SESSION['nom'].' '.$_SESSION['argent'].'€</h3>';
		?>
		</div>
		
		<?php
		if(isset($_GET['jouer']))
		{
			if($_GET['mise']!=null && $_GET['mise']<=$_SESSION['argent'] && $_GET['mise']>0 && $testparie!=1)
			{
				echo '<div class="alert alert-warning" role="alert">';
				echo '<h3>Nombre '.$resultat.'</h3>';
				echo '</div>';
			}
		}
		?>
		
		<?php
		if(isset($_GET['jouer']))
		{
			$test=0;
			if($_GET['mise']==null || $_GET['mise']==0 || $_GET['mise']<0)
			{
				echo '<div class="alert alert-danger" role="alert">';
				echo '<h3>Mise incorrect</h3>';
				echo '</div>';
				$test=1;
			}
			if(($_GET['mise']>$_SESSION['argent']) && $test!=1)
			{
				echo '<div class="alert alert-danger" role="alert">';
				echo '<h3>Pas assez d\'argent</h3>';
				echo'</div>';
			}
			if($testparie==1)
			{
				echo '<div class="alert alert-danger" role="alert">';
				echo '<h3>Veuillez sélectionner un nombre ou un type de nombre(paire ou impaire)</h3>';
				echo'</div>';
				$testparie=0;
			}
			if($perdugagne>0)
			{
				echo '<div class="alert alert-danger" role="alert">';
				echo '<h3>PERDU</h3>';
				echo'</div>';
			}
			if($perdugagne<0)
			{
				echo '<div class="alert alert-success" role="alert">';
				echo '<h3>GAGNE</h3>';
				echo'</div>';
			}
		}
		?>
		
		
		
		<div class="container">
			<form method="get">
				<div class="form-group row">
				  <div class="col-sm-10">
					<input type="mise" class="form-control" id="mise" placeholder="Votre mise" name="mise">
				  </div>
				</div>
				<hr width="100%">
				<div class="texte">Miser sur nombre</div>
				<div class="form-group row">
					<div class="col-sm-10">
						<input type="number" class="form-control" id="nombre" name="nombre" min="1" max="36">
					</div>
				</div>
				<hr width="100%">
				<div class="form-check form-check-inline">
					<label class="form-check-label">
					<input class="form-check-input" type="radio" name="im_paire" id="exampleRadios1" value="paire">
					Pair
					</label>
				</div>
				<div class="form-check form-check-inline">
					<div class="form-check">
						<label class="form-check-label">
						<input class="form-check-input" type="radio" name="im_paire" id="exampleRadios2" value="impaire">
						Impair
						</label>
					</div>
				</div>
				<hr width="100%">
				<div class="form-group row">
				<button id="bouton1" type="submit" class="btn btn-primary" name="jouer">Jouer</button>
				<button id="bouton2" type="submit" class="btn btn-primary" name="quitter">Quitter</button>
				</div>
			</form>
		</div>
	</body>
</html>