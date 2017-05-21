<?php

session_start();

require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>ULTIMATE VONG APP</title>

     <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>

</head>
<body>

	<div class="header">
		<a href="/">ULTIMATE VONG APP</a>
	</div>

	<?php if( !empty($user) ): ?>

		<br />Moin! <b><?= $user['email']; ?></b >
		<br /><br />Du hast dich erfolgreich eingeloggt!!
		<br /><br />
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<h1>Bitte einloggen oder registrieren</h1>
		<a href="login.php">Login</a> oder
		<a href="register.php">Registrieren</a>

	<?php endif; ?>

</body>
</html>