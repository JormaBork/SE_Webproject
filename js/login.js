
/*
Funktion fuer die Validierung der Login-Eingabe
===============================================
Das Laden dieser Funktion erfolgt mit dem Laden der index.php.
Mit der Methode .validate wird die eingebundene validation.min.js
aufgerufen. Es lassen sich entprechende Regeln und Nachtichten festlegen,
die bei einer korrekten oder inkorrekten An- bzw. Eingabe erscheinen.
 */
$('document').ready(function () {

    $("#login-form").validate({
        rules: {
            password: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            password: {
                required: "Bitte gib deinen Password ein!"
            },
            email: "Bitte gib deine Email-Adresse ein!",
        },
        submitHandler: submitForm
    });


    /*
    Funktion fuer die Uebermittlung der Login-Daten
    ==============================================
    Mit dem Click auf den Login-Button (Los gehts) werden die Daten an
    die login.php uebermittelt.
     */
    function submitForm() {
        var data = $("#login-form").serialize();

        $.ajax({

            type: 'POST',
            url: 'login.php',
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#btn-login").html('<span class="fa fa-transfer"></span> &nbsp; sende ...');
            },

            /*
            Der String des "echo" der login.php wird ausgewertet.  Ist dieser == wunderbar,
            so wird der Nutzer auf die meme.php weitergeleitet. In jedem anderen Falle
            erscheint ein Warnhinweis in der <div id="error"> der index.php
            */
            success: function (response) {
                if (response == "wunderbar") {

                    window.location.href = "meme.php";
                }
                else {

                    $("#error").fadeIn(500, function () {
                        $("#error").html('<div class="alert alert-danger"> <span class="fa fa-info-sign"></span> &nbsp; ' + response + ' !</div>');
                        $("#btn-login").html('<span class="fa fa-log-in"></span> &nbsp; Los gehts');
                    });
                }
            }
        });
        return false;
    }


});
