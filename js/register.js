/*
Funktion fuer die Validierung der Registrierungs-Eingabe
========================================================
Das Laden dieser Funktion erfolgt mit dem Laden der index.php.
Mit der Methode .validate wird die eingebundene validation.min.js
aufgerufen. Es lassen sich entprechende Regeln und Nachtichten festlegen,
die bei einer korrekten oder inkorrekten An- bzw. Eingabe erscheinen.
 */

$('document').ready(function () {

    $("#register-form").validate({
        rules: {
            user_name: {
                required: true,
                minlength: 3
            },
            user_password: {
                required: true,
                minlength: 6,
                maxlength: 15
            },
            re_password: {
                required: true,
                equalTo: '#user_password'
            },
            user_email: {
                required: true,
                email: true
            },
        },
        messages: {
            user_name: "Gib ein Namen ein",
            user_password: {
                required: "gib ein Passwort ein",
                minlength: "Länge von mindestens 6 Zeichen "
            },
            user_email: "Gib deine Email Adresse ein.",
            re_password: {
                required: "Wiederhole dein Password",
                equalTo: "Stimmt nicht überein. Erneut eingeben"
            }
        },
        submitHandler: submitForm
    });

    /*
    Funktion fuer die Uebermittlung der Registrierungs-Daten
    ========================================================
    Mit dem Click auf den Registrierungs-Button (Erstelle den Account) werden
    die Daten an die register.php uebermittelt.
     */
    function submitForm() {
        var data = $("#register-form").serialize();

        $.ajax({

            type: 'POST',
            url: 'register.php',
            data: data,
            beforeSend: function () {
                $("#error").fadeOut();
                $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sende ...');
            },
            success: function (data) {
                if (data == 1) {

                    $("#error").fadeIn(1000, function () {


                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; E-Mail ist bereits vergeben!</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle den Account');

                    });

                }
                /*
                Sofern die der zurueckgegebene String des echo's "registriert" enthaelt,
                war der Vorgang erfolgreich.
                Mit setTimeout wird das Ausblenden der Registrierungs-Elemente sowie das
                Einblenden der Login-Elemente verzoegert. Zudem erscheint (ebenfalls
                zeitverzoegert) eine SweetAlert-Message, die den Nutzer auf die erfolgreiche
                Registrierung hinweist.
                 */
                else if (data == "registriert") {

                    $("#btn-submit").html('registriere...');
                    setTimeout('$("#register-form, #registerheadline").fadeOut(1000);', 2500);
                    setTimeout('$("#login-form, #loginheadline").fadeIn(1000);', 4500);


                    setTimeout(function () {
                        swal({
                            title: "Registrierung erfolgreich!",
                            text: "Du kannst dich jetzt einloggen."
                        });
                    }, 4000);


                }
                else {

                    $("#error").fadeIn(1000, function () {

                        $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + data + ' !</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle den Account');

                    });

                }
            }
        });
        return false;
    }

  

});
