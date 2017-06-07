<?php
/*
========
REST API
========
FUER DIE LOESCHUNG UND UEBERMITTLUNG VON INFORMATIONEN DER MEMES
*/

$_SERVER["REQUEST_METHOD"];

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
      header('Content-type: application/json; charset=UTF-8');

    	$response = array();

    	require_once 'dbconn.php';

    	$mid = intval($_REQUEST["memeID"]);


      /*
      Prueft zunaechst, ob der passende Dateiname der angefragten ID des Memes
      in der Datenbank existiert und gibt diesen Dateinamen als §result
      */
    	$query = "SELECT filename FROM memes WHERE memeid=:mid";
    	$stmt_select = $DBcon->prepare( $query );
    	$stmt_select->execute(array(':mid'=>$mid));
    	$result = $stmt_select->fetchALL(PDO::FETCH_ASSOC);

      /*
      Sofern ein Dateiname ausgegeben worden ist, wird zunaechst die physisch
      vorhandende Datei geloescht und sodann der Eintrag aus der Datenbank entfernt.
      Die Information ueber Erfolg oder Misserfolg ($response) werden dann als
      JSON zurueck gegeben.
      */
    	if ($result) {
      		unlink("images/".$result[0]['filename']);
      		$query = "DELETE FROM memes WHERE memeid=:mid";
      		$stmt = $DBcon->prepare( $query );
      		$stmt->execute(array(':mid'=>$mid));
      		$response['status']  = 'success';
      		$response['message'] = 'Erfolgreich gelöscht... ';
    	} else {
      		$response['status']  = 'error';
      		$response['message'] = 'Fehler beim Löschen...';
    	}
	echo json_encode($response);
}

/*
Holt die Informationen aller Memes (Images) von der Datenbank
und gibt sie als JSON zurueck.
*/
if($_SERVER["REQUEST_METHOD"] == "GET") {

  if(isset($_GET['list'])) {
    header('Content-type: application/json; charset=UTF-8');

    require_once 'dbconn.php';

    $query = "SELECT * FROM memes";
    $stmt = $DBcon->prepare($query);
    $stmt->execute();
    #
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));


  } else {

    // Ausgabe eines einzelnen Memes mit all seinen Informationen
    $mid = intval($_REQUEST["memeID"]);
    require_once 'dbconn.php';
    $query = "SELECT * FROM memes WHERE memeid=$mid";
    $stmt = $DBcon->prepare($query);
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  }


}


 ?>
