<?php

	header('Content-type: application/json; charset=UTF-8');

	$response = array();

	if ($_POST['memeID']) {

		require_once 'dbconn.php';

		$pid = intval($_POST['memeID']);


		$query = "DELETE FROM memes WHERE memeid=:pid";
		$stmt = $DBcon->prepare( $query );
		$stmt->execute(array(':pid'=>$pid));

		if ($stmt) {
			$response['status']  = 'success';
			$response['message'] = 'Erfolgreich gelöscht... ';
		} else {
			$response['status']  = 'error';
			$response['message'] = 'Fehler beim Löschen...';
		}
		echo json_encode($response);
	}
