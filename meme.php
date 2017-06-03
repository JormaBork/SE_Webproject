<?php
session_start();
include_once 'dbconn.php';

// Falls keine Session besteht wird die index.php geladen.
if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

// Ueberprueft, ob der Nutzer eingeloggt ist.
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


    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Individuelle Schriftarten fuer dieses Template und fuer den MemeGenerator-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <!-- Zusaetzliche CSS fuer bootstrap und die SweetAltert Notifications -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.css" type="text/css"/>

    <!-- Angepassetes CSS fuer das grundsätzliche Bootrap Design-Schema  -->
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

        <div id="load-memes"></div>
        <!-- Die Tabelle wird hier hereingeladen -->

    </div>
</section>

<!-- JavaScript wie Jquery, Tether und Bootrapap, die fuer die Funktionen des Bootsrap Modals   -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="vendor/tether/tether.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>


<!-- Einbettung von jquery-easing, scrollreveal und magnific-popup sind teilweise fuer die Funktion des
"Creative Bootstrap Templates" notwendig. Zudem ermoeglichen sie nette features, wie z.B. das SmoothScrolling (scrollreveal)
Die SweetAlert2.min.js dient dazu, optisch anpsrechende Meldungen anzuzeigen.
  -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="https://cdn.jsdelivr.net/sweetalert2/6.6.2/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>


<!-- Zusaetzliches JavaScript fuer das Bootrap 'Creative' Template  -->
<script src="js/creative.min.js"></script>


<!--
DER MEMEGENERATOR
=================
-->
<script>

    /*
    Upload der Memes
    ===================
    */
    $(document).ready(function () {

        /*
        Mit Click auf den Upload-Button wird die Funktion gestartet
        das aktuelle Canvas Element eingelesen. Mit der Funktion
        "toDataURL" wird eine Methodothe ausgefuehrt, die eine dataURI zurueck
        gibt, welche eine Representation des Bildes beinhaltet (*.png)

        Zusaetzlich dazu wird der Variable "memetext" die Überschrift und der Untertitel
        des Memes eingelesen.
        */
        $("#uploadBtn").click(function () {
            var canvas = document.getElementById('canvas');
            var dataURL = canvas.toDataURL();
            var memetext = $("#topLineText").val() + " " + $("#bottomLineText").val();

            // Die Elemente dataURL und memetext werden als Array an die uploadMeme.php gesendet
            $.ajax({
                type: "POST",
                url: "uploadMeme.php",
                data: {img: dataURL, memetext: memetext}

            /*
            Wenn dies abgeschlossen ist, wird eine Meldung (msg) mit SweetAltert ausgegeben,
            welche in der uploadMeme.php als echo ausgegeben worden ist.
            Ferner wird die Funktion readMemes ausgefuehrt um die Taballe neu einzulesen.
            */
            }).done(function (msg) {
                swal(msg);
                readMemes();
            });
        });


    });

    // Funktion fuer das Lesen der Ueberschrift und des Untertitels
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

    // Funktion fuer das Zeichnen des Memes
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

        if (topLine) {
            drawMessage(canvas, ctx, 'top', topLine);
        }
        if (bottomLine) {
            drawMessage(canvas, ctx, 'bottom', bottomLine);
        }
    }
    // Festlegen der Schriftgroesse und Position der Buchstaben auf dem Canvas
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

    // Funktion fuer das Downlaoden des Memes. Sie verwendet FileSaver.js
      document.getElementById('download').addEventListener('click', function () {
        var canvas = document.getElementById('canvas');
        canvas.toBlob(function(blob){
          saveAs(blob, "meme.png");
        });
    });

    // Funktion fuer das Festlegen der Canvas-Groesse und das Handhaben der ausgewaehlten Bild-Datei
    function handleFileSelect(evt) {
        var canvasWidth = 500;
        var canvasHeight = 500;
        var file = evt.target.files[0];


        var reader = new FileReader();
        reader.onload = function (fileObject) {
            var data = fileObject.target.result;

            // Definiert/Erstellt ein neues "Image-Objekt"
            var image = new Image();
            image.onload = function () {

                window.imageSrc = this;
                redrawMeme(window.imageSrc, null, null);
            };

            // Legt fest, dass sich das ausgewaehlte Bild auf dem Hintergrund befinden wird.
            image.src = data;
            console.log(fileObject.target.result);
        };
        reader.readAsDataURL(file);
    }

    // Standardgemaeß liegt noch kein Text in der Ueberschrift oder im Untertitel
    window.topLineText = "";
    window.bottomLineText = "";
    // Der eingegebene Text wird in der Variablen input1 und input2 gespeichert.
    var input1 = document.getElementById('topLineText');
    var input2 = document.getElementById('bottomLineText');

    // Das oninput Ereignis tritt auf, wenn der Textinhalt eines Elements sich durch Benutzereingabe aendert.
    input1.oninput = textChangeListener;
    input2.oninput = textChangeListener;

    // Eventlistner fuer die ausgewaehlten Datei
    document.getElementById('file').addEventListener('change', handleFileSelect, false);


</script>


<script>
    /*
    TABELLE FUER DIE VERWALTUNG DER MEMES
    =====================================
    Laedt die Tabelle fuer die Verwaltung der Memes und reagiert auf Aenderungen,
    wie z.B. dem Loeschen eines Memes.
    */
    $(document).ready(function () {

        // Wenn das Dokument laed, wird die Tabelle geladen
        readMemes();

        /*
        Wenn auf den Loeschen-Button geclickt wird, dann
        die ID des Memes in der Variable memeID gespeichert
        und der Funktion SwalDelete uebergeben.

        */
        $(document).on('click', '#delete_meme', function (e) {

            var memeID = $(this).data('id');
            SwalDelete(memeID);
            e.preventDefault();
        });

    });

    /*
    FUNKTION FUER DIE LOESCHUNG DES MEMES
    ======================================
    Das Ausfuehren dieser Funktion triggert zunaechst
    einen SweetAltert-Dialog, bei dem der Nutzer den Vorgang
    ausfuehren oder abbrechen kann.
    */
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

            /*
            Mit der Nutzerbestaetigung der Loeschvorgangs
            wird die memeID als JSON an die delete.php
            uebermittelt.
            */
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: 'memeID=' + memeID,
                        dataType: 'json'
                    })

                        /*
                        Ausgabe einer Erfolgs-/Misserfolgsmeldung als SweetAltert-Message
                        und Neueinlesen der Tabelle.
                        */
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

    // Funktion zum Einlesen der Tabelle
    function readMemes() {
        $('#load-memes').load('readTable.php');
    }
</script>

</body>
</html>
