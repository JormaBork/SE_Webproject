<?php
session_start();

// Die uploadMeme.php soll nur getriggert werden koennen, wenn tatsaechlich eine Session besteht.
if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

require_once 'dbconn.php';

/*
Mit dem Upload-Button der meme.php ist ein Daten-Array uebermittelt worden.
Dieses beeinhaltet sowohl das Image, als auch den Memetext.
*/
$img = $_POST['img'];
$text = $_POST['memetext'];

/* Speicherung der Image-Datei auf dem Server
   Sucht zunaechst den String "data:image/png;base64" in der
   Varuable $img. Dieser befindet sich grundsaetzlich am Anfang
   der $img, weswegen der Rueckgabewert mit 0 verglichen wird.
*/
if (strpos($img, 'data:image/png;base64') === 0) {

    
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = 'images/' . date("YmdHis") . '.png';

    /*
    Die Anweisung file_put_contents legt das Bild im Ordner bzw. Pfad "images/"
    ab. Der Dateiname setzt sich dabei aus Jahr, Monat, Tag, Stunden, Minuten und
    Sekunden zusammen, sodass Dopplungen weitesgehend ausgeschlossen seien duerfte.
    */
    if (file_put_contents($file, $data)) {
      /*
      Speichert den filename in der $bild und die SessionID in der $id.
      Diese Informationen werden benoetigt, um den Dateinamen und den jeweligen
      User in der Tabelle Memes zu hinterlegen.

      substr wird hier benutzt, weil die Variable $file noch den Pfad enthaelt.
      */

        $bild = substr($file, 7);
        $id = $_SESSION['userSession'];

        // Try und Catch Block fuer besseres Error Handling.
        try {
            // Hinterlegt den Dateinamen, den Memetext und die UserID in der Datenbank
            $query = "INSERT INTO memes (filename, memetext, userid) VALUES(?, ?, ?)";
            $stmt = $DBcon->prepare($query);
            $stmt->execute(array($bild, $text, $id));

            // echo wird in der meme.php von SweetAltert ausgegeben.
            echo " Erfolgreich hochgeladen!";

        } catch (PDOException $e) {
            echo 'Leider gab es ein Problem';
        }


    }


}

?>
