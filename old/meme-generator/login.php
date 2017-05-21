<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: meme.php");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: meme.php");

	} else {
		$message = 'Angaben inkorrekt!';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login unten!</title>

	<!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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

	<h1>Login</h1>
	<span>oder <a href="register.php">hier registrieren</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Login-Mailadresse" name="email">
		<input type="password" placeholder="Passwort" name="password">

		<input type="submit">

	</form>

</body>
</html>