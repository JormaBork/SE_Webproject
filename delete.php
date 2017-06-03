<?php
	/*
	Loeschen des Memes
 ===================
	*/
	header('Content-type: application/json; charset=UTF-8');

	$response = array();

	if ($_POST['memeID']) {

		require_once 'dbconn.php';

		$mid = intval($_POST['memeID']);

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
