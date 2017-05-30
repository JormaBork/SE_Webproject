<?php

	header('Content-type: application/json; charset=UTF-8');

	$response = array();

	if ($_POST['memeID']) {

		require_once 'dbconn.php';

		$mid = intval($_POST['memeID']);

		// $stmt_select = $DB_con->prepare('SELECT filename FROM memes WHERE memeid =:mid');
		// $stmt_select->execute(array(':mid'=>$mid));
		// $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		// unlink("images/".$imgRow['filename']);

		$query = "SELECT filename FROM memes WHERE memeid=:mid";
		$stmt_select = $DBcon->prepare( $query );
		$stmt_select->execute(array(':mid'=>$mid));
		$result = $stmt_select->fetchALL(PDO::FETCH_ASSOC);

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
