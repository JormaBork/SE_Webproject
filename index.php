<?php
session_start();
require_once 'database.php';

if (isset($_SESSION['userSession'])!="") {
	header("Location: meme.php");
	exit;
}

if (isset($_POST['btn-login'])) {

	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);

	$query = $DBcon->query("SELECT id, email, password FROM users WHERE email='$email'");
	$row=$query->fetch_array();

	$count = $query->num_rows; // if email/password are correct returns must be 1 row

	if (password_verify($password, $row['password']) && $count==1) {
		$_SESSION['userSession'] = $row['id'];
		header("Location: meme.php");
	} else {
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
	}
	$DBcon->close();
}

?>

<!DOCTYPE html>
	<html lang="en">

	<head>

	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>ULTIMATE VONG MEMES</title>

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
	<body id="page-top">

	    <!-- Navigation -->
	    <nav class="navbar fixed-top navbar-toggleable-md navbar-light navbar-inverse bg-inverse" id="mainNav">
	        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
	            <span class="navbar-toggler-icon"></span>
	        </button>
	        <div class="container">
	            <a class="navbar-brand" href="#page-top">ULTIMATE VONG MEMES</a>
	            <div class="collapse navbar-collapse" id="navbarExample">
	                <ul class="navbar-nav ml-auto">
	                    <li class="nav-item">
	                        <a class="nav-link" href="#about">About</a>
	                    </li>

	                    <li class="nav-item">
	                        <a class="nav-link" href="#bspmemes">Beispiel Memes</a>
	                    </li>

											<li class="nav-item">
												 <a class="nav-link" href="#login">Login</a>
										 </li>

	                    <li class="nav-item">
	                        <a class="nav-link" href="#contact">Contact</a>
	                    </li>
	                </ul>
	            </div>
	        </div>
	    </nav>

	    <header class="masthead">
	        <div class="header-content">
	            <div class="header-content-inner">
	                <h1 id="homeHeading" div class="bg-inverse text-white">ULTIMATE VONG MEMES</h1>
	                <hr>
	                <p div class="bg-inverse text-white">Erstelle deine eigenenen Memes und teile Sie mit uns!</p>
	                <a class="btn btn-primary btn-xl" href="#about">Was sind Memes?</a>
	            </div>
	        </div>
	    </header>

	    <section class="bg-primary" id="about">
	        <div class="container">
	            <div class="row">
	                <div class="col-lg-8 offset-lg-2 text-center">
	                    <h2 class="section-heading text-white">Was sind Memes?</h2>
	                    <hr class="light">
	                    <p class="text-faded">Als Internetphänomen (auch Internet-Hype oder virales Phänomen) wird ein Konzept in Form eines Links oder einer Bild-, Ton- oder Videodatei bezeichnet, das sich schnell über das Internet verbreitet. Die am weitesten verbreitete Unterform ist die eines über das Internet verbreiteten Memes.</p>
	                    <a class="btn btn-default btn-xl sr-button" href="#bspmemes">Zeig mir Beispiele!</a>
	                </div>
	            </div>
	        </div>
	    </section>

			<!-- Beispiel Memes -->
		<section class="no-padding" id="bspmemes">
				<div class="container-fluid">
						<div class="row no-gutter">
								<div class="col-xs-6 col-sm-3">

												<img class="img-fluid" src="img/portfolio/thumbnails/1.jpg" alt="">


								</div>


							 <div class="col-xs-6 col-sm-3">

												<img class="img-fluid" src="img/portfolio/thumbnails/2.jpg" alt="">



								</div>
								<div class="col-xs-6 col-sm-3">

												<img class="img-fluid" src="img/portfolio/thumbnails/3.jpg" alt="">



								</div>
								<div class="col-xs-6 col-sm-3">

												<img class="img-fluid" src="img/portfolio/thumbnails/4.jpg" alt="">

								</div>


						</div>
				</div>
		</section>

			    <!-- Der Login Bereich -->
 <section id="login">
	 <div class="container">




	            <div class="row">
	                <div class="col-lg-12 text-center">
	                    <h2 class="section-heading">Login</h2>
	                    <hr class="primary">
	                </div>
	            </div>
<div class="signin-form">

	<div class="container">


       <form class="form-signin" method="post" id="login-form">



			<?php
	 	 		if(isset($msg)){
		 		echo $msg;
	 			}
	 		?>

			<div class="form-group">
        <input type="email" class="form-control" placeholder="Email Addresse" name="email" required />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Passwort" name="password" required />
        </div>

     

        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Los gehts
			</button>

            <a href="register.php" class="btn btn-default" style="float:right;">oder registriere dich hier</a>

        </div>



      </form>

    </div>



</div>







</body>
</html>
