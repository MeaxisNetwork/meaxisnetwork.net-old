<?php
	// If user isn't connected, redirect to a page asking him to log-in.
	if (!isset($_COOKIE['logcook']))
	{
		header("Location: signin.php?err=Veuillez vous connecter.");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MeaxisNetwork.net / Site du MeaxisNetwork.</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://meaxisnetwork.net/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="https://meaxisnetwork.net/assets/css/accounts.css">
	<link rel="stylesheet" media="screen and (max-width: 720px)" href="/assets/css/accounts_small.css" />
</head>
<body>
	<iframe width="100%" height="50px;" src="https://meaxisnetwork.net/assets/applets/navbar.php"></iframe>
	<?php
		// This asks the user to link his Discord Account.
		if ($final['isDLinked'] == "0") {
			echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px;" ">Pensez a lier votre <a class="alert-link" href="discord_link.php">Compte Discord</a> !</div>';
		}

		// This asks the user to verify his email if he doesn't have an Erozion Account.
		if ($final['isEmailLinked'] == "0") {
			if ($final['isEroAcc'] == "false") {
			echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px;" ">Veuillez <a class="alert-link" href="verify_email.php">vérifier votre email.</a></div>';
		}}

		// This was telling Erozion Account users to migrate to MeaxisNetwork accounts because they were more limited.
		if ($final['isEroAcc'] == "true") {
			echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px;" ">Les fonctionnalités d\'un compte ErozionID sont limitées ! Pour tout débloquer, passez à un <a class="alert-link" href="discord_link.php">Compte MeaxisNetwork</a> !</div>';
		}

	?>
	<?php
		// When pages redirected to this page, they could send a message with them, this displayed it.
		if (isset($_GET['msg']))
		{
			$errcode = $_GET['msg'];
			echo '<div class="alert alert-secondary" role="alert" style="margin-left:150px; margin-right:150px; margin-top: 25px; margin-botoom: 0px;" ">', $errcode, '</div>';
		}
	?>

	<!--- Button to log-off --->
	<a class="logoff-button" style="" href="signout.php">Déconnexion</a>
	<?php
		// Log-in to database
		$bdd = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8', 'username', 'password');

		// Find the user's account by searching an account with the same cookie as the current account.
		$req = $bdd->prepare('SELECT * FROM accounts WHERE logcook = :logcook');
		$req->execute(array(
			'logcook' => $_COOKIE['logcook']
		));

		while ($treated = $req->fetch())
		{
			// Store user infos
			$username = $treated['username'];
			$userid = $treated['id'];

			// Show user a welcome message ("Hello, user")
			echo "<h1>Bienvenue, ", $username, " !</h1>";

			// If premium, show a message thanking the user
			if ($treated['isPremium'] == 1)
			{
				echo "Ooh, vous êtes MeaxisNetwork Premium ! Merci beaucoup d'aider le MeaxisNetwork !";
			}

			// Connect to the services database. 
			$bdd2 = new PDO('mysql:host=localhost;dbname=website;charset=utf8', 'username', 'password');

			// Search for the user's services in the database
			$req2 = $bdd2->prepare('SELECT *, DATE_FORMAT(expiration_date, "%d/%m/%y") AS expiration_date FROM services WHERE meaxis_id = :id');
			$req2->execute(array(
				'id' => $userid
			));

			$treated2 = $req2->fetch();

			// If the service existed then:
			if (isset($treated2['name']))
			{
				echo "<table class=\"service_showcase\"> <tr><th>Nom du service</th> <th>Description du service</th> <th>Identifiant</th> <th>Date d'expiration</th> <th>Lien</th>";
				echo "<tr><td>", $treated2['name'], "</td><td>", $treated2['descrip'], "</td><td>", $treated2['id'], "</td><td>", $treated2['expiration_date'], "</td><td class=\"table-button\"><a href=\"/accounts/services/?id=", $treated2['id'], "\" class=\"table-button\">Y aller !</a>", "</td></tr>";
			}
		}
	?>
	</table>
</body>
</html>