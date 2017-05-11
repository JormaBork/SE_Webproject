<?php

session_start();

require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}


?>

<!DOCTYPE html>

<html>
<head>
  <title>ULTIMATE VONG Meme Generator</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <style>
    html, body {
      height: 100%;
      width: 100%;
    }
    #image-container {
      display: flex;
    }
    canvas {
      border: 1px solid black;
    }
    .content {
      display: table;
      height: 100%;
      margin: 0 auto;
    }
    .container {
      display: table-cell;
      vertical-align: middle;
    }
    .container * {
      margin: 16px;
    }
    h1 {
      font-family: sans-serif;
      text-align: center;
    }
  </style>
</head>

<body>



  <div class="content">
    <div class="container">
      <h1>ULTIMATE VONG Meme Generator</h1>
	   <?php if( !empty($user) ): ?>

	
		
		<br /><br />
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<h1>Bitte einloggen oder regisrieren</h1>
		<a href="login.php">Login</a> oder
		<a href="register.php">Registrierung</a>

	<?php endif; ?>
	  
	  
	  
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

      ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
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