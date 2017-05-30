<?php
  session_start();

  if (!isset($_SESSION['userSession'])) {
      header("Location: index.php");
  }

  require_once 'dbconn.php';

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

            // Error Handling fuer DB 
        try {

            $query= "INSERT INTO memes (filename, memetext, userid) VALUES(?, ?, ?)";
            $stmt = $DBcon->prepare( $query );
            $stmt->execute(array($bild, $text, $id));
            echo " Erfolgreich hochgeladen!";

        } catch( PDOException $e ) {
                echo 'Leider gab es ein Problem';
              }


      }




   }

?>
