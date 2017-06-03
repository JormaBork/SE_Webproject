<?php
session_start();
include_once 'dbconn.php';

if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

$userID = $_SESSION['userSession'];
$query = "SELECT id FROM users WHERE id=$userID";
$stmt = $DBcon->prepare($query);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$results = count($results);

?>

<!DOCTYPE html>

<html>
<head>
    <title>ULTIMATE VONG Meme Generator</title>


    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">


    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.css" type="text/css"/>

    <!-- Custom styles for this template -->
    <link href="css/creative.css" rel="stylesheet">


    <style>

    </style>

</head>

<body>
<body id="page-top">
<!-- Navigation -->
<nav class="navbar fixed-top navbar-toggleable-md navbar-inverse bg-inverse" id="mainNav">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
        <a class="navbar-brand" href="#page-top">ULTIMATE VONG MEMES GENERATOR</a>
        <div class="collapse navbar-collapse" id="navbarExample">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Hauptseite</a>

                </li>


                <li class="nav-item">
                    <?php if ($results > 0): ?>
                        <a class="nav-link" href="logout.php?logout">Logout</a>
                    <?php endif; ?>
                </li>


            </ul>
        </div>
    </div>
</nav>

<section id="memegen">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Erstelle deine eigenen Memes</h2>

                <p class="text">Lade einfach die gewünschte Datei und bearbeite sie.</p>
                <label class="btn btn-primary btn-file">Datei auswählen <input type="file" id="file"
                                                                               style="display: none"></label>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12" id="image-container">
                        <canvas width="500" height="500" id="canvas" style="background-color: grey;"></canvas>
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="usr">&Uuml;berschrift:</label>
                                    <input type="text" class="form-control" id="topLineText">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-5">
                                    <label for="usr">Untertitel:</label>
                                    <input type="text" class="form-control" id="bottomLineText">
                                </div>


                            </div>
                            <div class="btn-group-vertical" data-toggle="buttons">
                                <label class="btn btn-primary" id="uploadBtn">Upload</label>
                                <a class="btn btn-primary" id="download" role="button">Download</a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
</section>

<section id="editmeme">
    <div class="container">

        <div class="page-header">
            <h3>Verwalte deine Memes</h3>
        </div>

        <div id="load-memes"></div> <!-- products will be load here -->

    </div>
</section>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="vendor/tether/tether.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/creative.min.js"></script>

<script>


    // UPLOAD DES MEMES
    $(document).ready(function () {

        $("#uploadBtn").click(function () {
            var canvas = document.getElementById('canvas');
            var dataURL = canvas.toDataURL();
            var memetext = $("#topLineText").val() + " " + $("#bottomLineText").val();

            $.ajax({
                type: "POST",
                url: "uploadMeme.php",
                data: {img: dataURL, memetext: memetext}

            }).done(function (msg) {
                swal(msg);
                readMemes();
            });
        });


    });


    function textChangeListener(evt) {
        var id = evt.target.id;
        var text = evt.target.value;

        if (id == "topLineText") {
            window.topLineText = text;
        } else {
            window.bottomLineText = text;
        }

        redrawMeme(window.imageSrc, window.topLineText, window.bottomLineText);
    }

    function redrawMeme(image, topLine, bottomLine) {
        // Get Canvas2DContext
        var canvas = document.querySelector('canvas');
        var ctx = canvas.getContext("2d");

        //Perfekte Bildskalierung
        var destWidth = canvas.width;
        var destHeight = canvas.height;
        var sourceX = 0;
        var sourceY = 0;
        var sourceWidth = image.width;
        var sourceHeight = image.height;
        if (sourceWidth > sourceHeight) {
            sourceX = (sourceWidth - sourceHeight) / 2;
            sourceWidth = sourceHeight;
        } else if (sourceHeight > sourceWidth) {
            sourceY = (sourceHeight - sourceWidth) / 2;
            sourceHeight = sourceWidth;
        }
        ctx.drawImage(image, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, destWidth, destHeight);

        // ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        if (topLine) {
            drawMessage(canvas, ctx, 'top', topLine);
        }
        if (bottomLine) {
            drawMessage(canvas, ctx, 'bottom', bottomLine);
        }
    }

    function drawMessage(canvas, ctx, position, message) {
        var fontSize = 46;
        var padding = 10;
        var verticalPosition = function () {
            if (position === 'top') {
                return fontSize + padding;
            } else {
                return canvas.height - padding;
            }
        };
        ctx.font = '400 small-caps 44pt Anton';
        ctx.textAlign = 'center';
        ctx.fillStyle = 'white';
        ctx.fillText(message, canvas.width / 2, verticalPosition());
        ctx.strokeStyle = 'black';
        ctx.lineWidth = fontSize / 18;
        ctx.strokeText(message, canvas.width / 2, verticalPosition());
    }


    function downloadCanvas(link, canvasId, filename) {
        link.href = document.getElementById(canvasId).toDataURL();
        link.download = filename;
    }
    document.getElementById('download').addEventListener('click', function () {
        downloadCanvas(this, 'canvas', 'meme.png');
    }, false);


    function handleFileSelect(evt) {
        var canvasWidth = 500;
        var canvasHeight = 500;
        var file = evt.target.files[0];


        var reader = new FileReader();
        reader.onload = function (fileObject) {
            var data = fileObject.target.result;

            // Create an image object
            var image = new Image();
            image.onload = function () {

                window.imageSrc = this;
                redrawMeme(window.imageSrc, null, null);
            };

            // Set image data to background image.
            image.src = data;
            console.log(fileObject.target.result);
        };
        reader.readAsDataURL(file);
    }

    window.topLineText = "";
    window.bottomLineText = "";
    var input1 = document.getElementById('topLineText');
    var input2 = document.getElementById('bottomLineText');
    input1.oninput = textChangeListener;
    input2.oninput = textChangeListener;
    document.getElementById('file').addEventListener('change', handleFileSelect, false);
    // document.querySelector('#uploadBtn').addEventListener('click', uploadFile, false);


</script>
<script>

    // TABELLE FUER DIE VERWALTUNG DER MEMES
    $(document).ready(function () {

        readMemes();
        /* it will load products when document loads */

        $(document).on('click', '#delete_meme', function (e) {

            var memeID = $(this).data('id');
            SwalDelete(memeID);
            e.preventDefault();
        });

    });

    function SwalDelete(memeID) {

        swal({
            title: 'Bist du dir sicher?',
            text: "Dein Meme wird dadurch dauerhaft gelöscht!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Abbrechen',
            confirmButtonText: 'Ja, weg damit!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: 'memeID=' + memeID,
                        dataType: 'json'
                    })
                        .done(function (response) {
                            swal('Gelöscht!', response.message, response.status);
                            readMemes();
                        })
                        .fail(function () {
                            swal('Oops...', 'Da ist was schief gelaufen', 'error');
                        });
                });
            },
            allowOutsideClick: false
        });

        readMemes();

    }

    function readMemes() {
        $('#load-memes').load('readTable.php');
    }
</script>

</body>
</html>
