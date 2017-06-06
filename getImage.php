<?php
/*
Holt die Dateinamen aller Memes (Images) von der Datenbank
und gibt sie als JSON zurueck.
*/

header('Content-type: application/json; charset=UTF-8');


require_once 'dbconn.php';



$query = "SELECT * FROM memes";
$stmt = $DBcon->prepare($query);
$stmt->execute();




echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));


?>
