<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	// Enter the new user in the database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Neuer Nutzer erfolgreich erstellt!';
	else:
		$message = 'Upps, da gab es wohl ein kleines Problem';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registriere Dich unten!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">ULTIMATE VONG APP</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Registrierung</h1>
	<span>oder <a href="login.php">logge dich hier ein!</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="trage deine Email ein" name="email">
		<input type="password" placeholder="und dein Passwort" name="password">
		<input type="password" placeholder="bestätige dein Passwort erneut" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>