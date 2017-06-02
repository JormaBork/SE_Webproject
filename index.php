<?php
session_start();
include_once 'dbconn.php';
$results = 0;


if (isset($_SESSION['userSession'])) {

$userID = $_SESSION['userSession'];
$query = "SELECT id FROM users WHERE id=$userID";
$stmt = $DBcon->prepare( $query );
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$results = count($results);

}

?>

<!DOCTYPE html>
<html lang="de">

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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./slick/slick.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.css" type="text/css" />


    <!-- Custom styles for this template -->
    <link href="css/creative.css" rel="stylesheet">

    <style type="text/css">

        .slider {
            width: 90%;
            margin: auto;
        }

        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }
    </style>

</head>

<body>
<body id="page-top">

<!-- Navigation -->
<nav class="navbar fixed-top navbar-toggleable-md navbar-light navbar-inverse bg-inverse" id="mainNav">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false"
            aria-label="Toggle navigation">
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
                    <?php if ($results > 0): ?>
                        <a class="nav-link" href="meme.php">Generator</a>
                    <?php endif; ?>
                </li>

                <li class="nav-item">
                    <?php if ($results > 0): ?>
                        <a class="nav-link" href="logout.php?logout">Logout</a>
                    <?php endif; ?>
                </li>

                <li class="nav-item">
                    <?php if ($results == 0): ?>
                    <a class="nav-link" href="#login">Login</a>
                    <?php endif; ?>
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
                <p class="text-faded">Als Internetphänomen (auch Internet-Hype oder virales Phänomen) wird ein Konzept
                    in Form eines Links oder einer Bild-, Ton- oder Videodatei bezeichnet, das sich schnell über das
                    Internet verbreitet. Die am weitesten verbreitete Unterform ist die eines über das Internet
                    verbreiteten Memes.</p>
                <a class="btn btn-default btn-xl sr-button" href="#bspmemes">Zeig mir Beispiele!</a>
            </div>
        </div>
    </div>
</section>

<!-- Beispiel Memes -->
<section class="regular slider" id="bspmemes">
<!-- Slider Images erscheinen hier  -->

</section>

<!-- Der Login Bereich -->
<?php if ($results == 0): ?>
<section id="login">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading" id="loginheadline">Login</h2>
              <h2 class="section-heading" id="registerheadline" style="display: none;">Registrierung</h2>                <hr class="primary">
            </div>
        </div>
        <div class="signin-form">

            <div class="container">
              <div id="error">
              <!-- error will be shown here ! -->
              </div>

                <form class="form-signin" method="post" id="login-form">




                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Addresse" name="email" id="email"/>
                        <span id="check-e"></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Passwort" name="password" id="password"/>
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Los gehts
                        </button>

                        <a href="#" class="btn btn-default" style="float:right;" id="register-form-link">oder registriere dich
                            hier</a>

                    </div>


                </form>
                <!-- Registrierung -->
                <form class="form-signin" method="post" id="register-form" style="display: none;">


                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="user_name" id="user_name" />
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Addresse" name="user_email" id="user_email" />
                        <span id="check-e"></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Passwort" name="user_password" id="user_password" />
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Wiederhole dein Passwort" name="re_password" id="re_password" />
                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle den Account
                        </button>
                        <a href="#" class="btn btn-default" style="float:right;" id="login-form-link">Oder logge dich hier ein</a>

                    </div>

                </form>






            </div>

        </div>
  </div>
</section>
<?php endif; ?>


        <!-- JavaScript fuer den Jquery den Slider sowie Tether und Bootrapap JS fuer die Funktionen des Bootsrap Modals  -->
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
        <script src="vendor/tether/tether.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- JavaScript fuer den Login und die Validierung der Login Daten -->
        <script type="text/javascript" src="./js/validation.min.js"></script>
        <script type="text/javascript" src="./js/login.js"></script>
        <script type="text/javascript" src="./js/register.js"></script>



        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
        <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
        <script src="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.js"></script>


        <!-- Zusaetzliches JavaScript fuer das Bootrap Template  -->
        <script src="js/creative.min.js"></script>

        <!-- Einstellungen von Slick Slider  -->
        <script type="text/javascript">
            $(document).on('ready', function () {
                $(".regular").slick({
                    dots: true,
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                      {
                        breakpoint: 2100,
                        settings: {
                          slidesToShow: 4,
                          slidesToScroll: 4,
                          infinite: true,
                          dots: true
                        }
                      },

                      {
                        breakpoint: 1600,
                        settings: {
                          slidesToShow: 3,
                          slidesToScroll: 3,
                          infinite: true,
                          dots: true
                        }
                      },
                    {
                      breakpoint: 1000,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 700,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }

                  ]
                });
                $(".center").slick({
                    dots: true,
                    infinite: true,
                    centerMode: true,
                    slidesToShow: 3,
                    slidesToScroll: 3
                });
                $(".variable").slick({
                    dots: true,
                    infinite: true,
                    variableWidth: true
                });
            });
        </script>

        <script>


            $(function () {
                $.ajax({
                    type: "GET",
                    url: "getImage.php",
                    dataType: "json",
                    success: function (data) {

                        $.each(data, function (i, filename) {

                            $('.container').on('dragstart', 'img', function () {
                                return false;
                            });
                            $('.regular.slider').slick('slickAdd', "<div><img src=images/" + filename + "></div>");

                        });
                    }
                });
            });


        </script>

        <script>
        $(function() {

          $('#login-form-link').click(function(e) {
              $("#login-form").delay(100).fadeIn(100);
              $("#loginheadline").fadeIn(100);
              $("#register-form").fadeOut(100);
              $("#registerheadline").fadeOut(100);
              $('#register-form-link').removeClass('active');
              $(this).addClass('active');
              e.preventDefault();
           });
          $('#register-form-link').click(function(e) {
              $("#register-form").delay(100).fadeIn(100);
              $("#registerheadline").fadeIn(100);
              $("#login-form").fadeOut(100);
              $("#loginheadline").fadeOut(100);
              $('#login-form-link').removeClass('active');
              $(this).addClass('active');
              e.preventDefault();
           });

          });
      </script>


</body>
</html>
