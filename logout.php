<?php
session_start();

/*
Mit der Ausfuehrung der logout.php wird der Nutzer abgemeldet
Mit unset() wird die angegebene Variable gelöscht. Die session_destroy()
löscht alle in Verbindung mit der aktuellen Session stehenden Daten.
So dann wird der Nutzer auf die Startseite (index.php) weitergeleitet.
*/
if (isset($_GET['logout'])) {
    
    unset($_SESSION['userSession']);
    session_destroy();
    header("Location: index.php");
}
