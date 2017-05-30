<?php
  session_start();

  if (!isset($_SESSION['userSession'])) {
      header("Location: index.php");
  }

  require_once 'database.php';

   $img = $_POST['img'];
   $text = $_POST['memetext'];

   if (strpos($img, 'data:image/png;base64') === 0) {

      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $file = 'images/'.date("YmdHis").'.png';

      if (file_put_contents($file, $data)) {
        $bild = substr($file, 7);
        $id = $_SESSION['userSession'];

        $query= "INSERT INTO memes (filename, memetext, userid) VALUES('$bild','$text','$id')";

        if ($DBcon->query($query)) {


        } else {

        }

        $DBcon->close();
       echo " Erfolgreich hochgeladen!";

      } else {
         echo 'Konnte nicht hochgeladen werden.';
      }

   }

?>
