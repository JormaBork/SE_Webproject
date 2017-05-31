

$('document').ready(function()
{
     /* validation */
	 $("#login-form").validate({
      rules:
	  {
			password: {
			required: true,
			},
			email: {
            required: true,
            email: true
            },
	   },
       messages:
	   {
            password:{
                      required: "Bitte gib deinen Password ein!"
                     },
            email: "Bitte gib deine Email-Adresse ein!",
       },
	   submitHandler: submitForm
       });
	   /* validation */

     /* login submit */
	   function submitForm()
	   {
			var data = $("#login-form").serialize();

			$.ajax({

			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function()
			{
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success :  function(response)
			   {
					if(response=="wunderbar"){

						window.location.href = "meme.php";
					}
					else{

						$("#error").fadeIn(500, function(){
				$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
											$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Log In');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});
