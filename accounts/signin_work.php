<?php
$email = $_POST['email'];
$password = $_POST['password'];

if (!isset($_POST['email'])) {
	echo "ok fail";
}

if (isset($_POST['email'], $_POST['password'])) {
	echo "ok step 1 is good";
	$bdd = new PDO('mysql:host=localhost;dbname=accounts;charset=utf8', 'username', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$req = $bdd->prepare('SELECT * FROM accounts WHERE email = :email');
	$req->execute(array(
		'email' => $email
	));
	echo "ok step 2 is good";
	while ($finishedtreat = $req->fetch()) {
		echo $email, "200 OK all fields are there | ", $finishedtreat['email'], " | ",  $finishedtreat['password'], " | ", $password, " | ";
		if ($pconf = password_verify($password, $finishedtreat['password']))
		{
			echo "ok step 3 is good";
			$req = $bdd->prepare('SELECT * FROM accounts WHERE password = :password AND email = :email');
			$req->execute(array(
				'password' => $finishedtreat['password'],
				'email' => $email
			));
			while ($finished_data = $req->fetch())
			{
				setcookie('logcook', $finished_data['logcook'], time()+3600*24*365, "/", "meaxisnetwork.net");
				header("Location: signin.php?error=Succès !");
			}
		}
		else
		{
			header("Location: signin.php?error=Mot de passe invalide !");
		}
	}
}

else
{
	echo "Unknown error";
	header("signin.php?error=Erreur inconnue. Veuillez réessayer.");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Traitement</title>
	<meta http-equiv="refresh" content="0.2;signin.php?error=Erreur inconnue, veuillez réeesayer. (Ceci est souvent causé par des identifiants incorrects).">
</head>
<body>
<p>Traitement en cours !</p>
</body>
</html>