<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: meme.php");
}
require_once 'database.php';

if(isset($_POST['btn-signup'])) {


	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);


	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);

	$hashed_password = password_hash($upass, PASSWORD_DEFAULT);

	$check_email = $DBcon->query("SELECT email FROM users WHERE email='$email'");
	$count=$check_email->num_rows;

	if ($count==0) {

		$query = "INSERT INTO users(email,password) VALUES('$email','$hashed_password')";

		if ($DBcon->query($query)) {
			$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Du hast dich erfolgreich registriert !
					</div>";
		}else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Hoppla...da gab es wohl einen Fehler !
					</div>";
		}

	} else {


		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Die E-Mail ist bereits vergeben !
				</div>";

	}

	$DBcon->close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registriere Dich unten!</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom fonts for this template -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

	<!-- Plugin CSS -->
	<link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/creative.min.css" rel="stylesheet">
</head>
<body>



<div class="signin-form">

	<div class="container">


       <form class="form-signin" method="post" id="register-form">

        <h2 class="form-signin-heading">Registrierung</h2>

        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>



        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email Addresse" name="email" required  />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Passwort" name="password" required  />
        </div>



        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle dir einen Account
			</button>
            <a href="index.php#login" class="btn btn-default" style="float:right;">Oder logge dich hier ein</a>
        </div>

      </form>

    </div>

</div>

</body>
</html>
