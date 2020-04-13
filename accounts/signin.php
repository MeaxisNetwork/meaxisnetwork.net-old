<?php
include("databases.php");

if (isset($_COOKIE['logcook']))
{
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MeaxisNetwork.net / Site du MeaxisNetwork.</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/accounts.css">
	<link rel="stylesheet" media="all and (max-device-width: 720px)" href="/assets/css/accounts_small.css" />
	<link rel="stylesheet" media="all and (max-width: 720px)" href="/assets/css/accounts_small.css" />
</head>
<body>
<iframe width="100%" height="50px;" src="https://meaxisnetwork.net/assets/applets/navbar.php"></iframe>
	<?php
	if (isset($_GET['error']))
	{
	$errcode = $_GET['error'];
	echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px; margin-botoom: 0px;" ">', $errcode, ' ', '<a class="alert-link" href="forgot.php">Identifiants oubliés ?</a>', '</div>';
	}

	elseif (isset($_GET['err']))
	{
		$errcode = $_GET['err'];
		echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px; margin-botoom: 0px;" ">', $errcode, ' ', '<a class="alert-link" href="forgot.php">Identifiants oubliés ?</a>', '</div>';
	}
	?>
<div class="login-popup">
	<h2 class="login-title">Se connecter</h2>
	<form action="signin_work.php" method="post">
		<label for="email">Adresse e-mail</label>
		<input type="email" name="email" required>
		<label for="password">Mot de passe</label>
		<input type="password" name="password" required>
		<input class="login-button" type="submit" name="submit">
		<a class="link" href="signup.php"><p class="link">Je n'ai pas de compte !</p></a>
	</form>
	<a class="btn btn-warning" class="erobutton" style="display: block; margin-left: auto; margin-right: auto;" href="ero_traitement.php">Connexion avec ErozionID</a>
</div>
</body>
</html>