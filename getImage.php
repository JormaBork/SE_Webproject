<?php
/*
Holt die Dateinamen aller Memes (Images) von der Datenbank
und gibt sie als JSON zurueck.
*/

header('Content-type: application/json; charset=UTF-8');


require_once 'dbconn.php';

// Definition des Arrays
$dbArray = array();


$query = "SELECT filename FROM memes";
$stmt = $DBcon->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($dbArray, $row['filename']);
}


echo json_encode($dbArray);


?>
