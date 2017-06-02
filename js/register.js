$('document').ready(function()
{
    // Validierung der Eingabe
    $("#register-form").validate({
        rules:
        {
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
        messages:
        {
            user_name: "Gib ein Namen ein",
            user_password:{
                required: "gib ein Passwort ein",
                minlength: "Länge von mindestens 6 Zeichen "
            },
            user_email: "Gib deine Email Adresse ein.",
            re_password:{
                required: "Wiederhole dein Password",
                equalTo: "Stimmt nicht überein. Erneut eingeben"
            }
        },
        submitHandler: submitForm
    });

// Uebermittlung der Daten
    function submitForm()
    {
        var data = $("#register-form").serialize();

        $.ajax({

            type : 'POST',
            url  : 'register.php',
            data : data,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sende ...');
            },
            success :  function(data)
            {
                if(data==1){

                    $("#error").fadeIn(1000, function(){


                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; E-Mail ist bereits vergeben!</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle den Account');

                    });

                }
                else if(data=="registriert")
                {

                    $("#btn-submit").html('registriere...');
                    setTimeout('$("#register-form, #registerheadline").fadeOut(1000);', 2500);
                    setTimeout('$("#login-form, #loginheadline").fadeIn(1000);', 4500);


                    setTimeout(function(){
                       swal({
                              title: "Registrierung erfolgreich!",
                              text: "Du kannst dich jetzt einloggen."
                            });
                    }, 4000);



                }
                else{

                    $("#error").fadeIn(1000, function(){

                        $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');

                        $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Erstelle den Account');

                    });

                }
            }
        });
        return false;
    }
    /* form submit */

});
