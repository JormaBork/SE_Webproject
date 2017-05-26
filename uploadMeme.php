<?php
  session_start();

  if (!isset($_SESSION['userSession'])) {
      header("Location: index.php");
  }

  require_once 'database.php';

   $img = $_POST['img'];

   if (strpos($img, 'data:image/png;base64') === 0) {

      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $file = 'images/'.date("YmdHis").'.png';

      if (file_put_contents($file, $data)) {
        $bild = substr($file, 7);
        $id = $_SESSION['userSession'];

        $query= "INSERT INTO memes (filename, userid) VALUES('$bild','$id')";

        if ($DBcon->query($query)) {

            echo 'DB okay!';
        } else {
            echo 'DB nicht okay!';
        }

        $DBcon->close();
       echo " Erfolgreich hochgeladen!";

      } else {
         echo 'Konnte nicht hochgeladen werden.';
      }

   }

?>
