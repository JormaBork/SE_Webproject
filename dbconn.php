<?php
/*
Die Datenbankverbindung
=======================
Die dbconn.php wird von fast allen anderen Dateien benoetigt,
um eine Datenbankabfrage in MySQL zu starten.
*/


  // Definition der notwendigen Variablen fuer die Verbindung 
 $DBhost = "localhost";
 $DBuser = "root";
 $DBpass = "";
 $DBname = "datenbank";


/* Um Fehler besser analysieren zu koennen,
ist der Datenbankverbindung ein TryCatch Block vorweg gestellt
*/

 try{

  $DBcon = new PDO("mysql:host=$DBhost;dbname=$DBname",$DBuser,$DBpass);
  $DBcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 }catch(PDOException $ex){

  die($ex->getMessage());
 }
