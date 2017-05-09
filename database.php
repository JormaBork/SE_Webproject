<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'datenbank';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Verbindung fehlgeschlagen: " . $e->getMessage());
}