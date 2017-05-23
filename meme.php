<?php
session_start();
include_once 'database.php';

if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>

<!DOCTYPE html>

<html>
<head>
    <title>ULTIMATE VONG Meme Generator</title>


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
        <a class="navbar-brand" href="#page-top">ULTIMATE VONG MEMES GENERATOR</a>
        <div class="collapse navbar-collapse" id="navbarExample">
            <ul class="navbar-nav ml-auto">


                <li class="nav-item">
                    <?php if( !empty($userRow) ): ?>
                        <a class="nav-link" href="logout.php?logout">Logout</a>
                    <?php endif; ?>
                </li>


            </ul>
        </div>
    </div>
</nav>

<div class="content">
    <div class="container">
        <h1>ULTIMATE VONG Meme Generator</h1>




        <div>
            <input type="file" id="file" />
        </div>
        <div id="image-container">
            <canvas width="500" height="500"></canvas>
            <div>
                <span>&Uuml;berschrift:</span><br/>
                <input id="topLineText" type="text"><br/>
                <span>Untertitel:</span><br/>
                <input id="bottomLineText" type="text"><br/>
                <button id="saveBtn">Speichern</button>
            </div>
        </div>
    </div>
</div>
<script>
    function textChangeListener (evt) {
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
        if (topLine) { drawMessage(canvas, ctx, 'top', topLine); }
        if (bottomLine) { drawMessage(canvas, ctx, 'bottom', bottomLine); }
    }

    function drawMessage(canvas, ctx, position, message) {
        var fontSize = 50;
        var padding = 10;
        var verticalPosition = function() {
            if (position === 'top') {
                return fontSize + padding;
            } else {
                return canvas.height - padding;
            }
        };
        ctx.font = fontSize + 'pt Impact';
        ctx.textAlign = 'center';
        ctx.fillStyle = 'white';
        ctx.fillText(message, canvas.width / 2, verticalPosition());
        ctx.strokeStyle = 'black';
        ctx.lineWidth = fontSize/14;
        ctx.strokeText(message, canvas.width / 2, verticalPosition());
    }

    function saveFile() {
        window.open(document.querySelector('canvas').toDataURL());
    }


    function handleFileSelect(evt) {
        var canvasWidth = 500;
        var canvasHeight = 500;
        var file = evt.target.files[0];



        var reader = new FileReader();
        reader.onload = function(fileObject) {
            var data = fileObject.target.result;

            // Create an image object
            var image = new Image();
            image.onload = function() {

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
    document.querySelector('button').addEventListener('click', saveFile, false);
</script>

</body>
</html>
