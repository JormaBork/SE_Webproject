<?php

	header('Content-type: application/json; charset=UTF-8');

	$response = array();

	if ($_POST['delete']) {

		require_once 'dbconn.php';

		$pid = intval($_POST['delete']);
		$query = "DELETE FROM memes WHERE memeid=:pid";
		$stmt = $DBcon->prepare( $query );
		$stmt->execute(array(':pid'=>$pid));

		if ($stmt) {
			$response['status']  = 'success';
			$response['message'] = 'Product Deleted Successfully ...';
		} else {
			$response['status']  = 'error';
			$response['message'] = 'Unable to delete product ...';
		}
		echo json_encode($response);
	}
