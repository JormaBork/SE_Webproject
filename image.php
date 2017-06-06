<?php

$_SERVER["REQUEST_METHOD"];

$id = intval($_REQUEST["memeID"]);

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
  header('Content-type: application/json; charset=UTF-8');

	$response = array();

	require_once 'dbconn.php';

	$mid = $id;

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

if($_SERVER["REQUEST_METHOD"] == "GET") {
  
}


 ?>
