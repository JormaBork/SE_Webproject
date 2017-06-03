<?php
/*
Die Ausfuehrung der Login-Anfrage
====================================
Die login.php empfaegt die uebermittelten Daten und wertet diese aus.

*/
session_start();
require_once 'dbconn.php';


if (isset($_POST['btn-login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password = md5($password);

    // Try und Catch Block fuer besseres Error Handling.
    try {
        // Prueft zunaechst ob die Email existiert
        $stmt = $DBcon->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(array(":email" => $email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        /*
        Sofern das eingegebene Passwort dem in der Datenbank hinterlegten entspricht,
        ist der Vorgang erfolgreich. Andernfalls handelt es sich um eine fehlerhafte
        Eingabe.
        */
        if ($row['password'] == $password) {

            echo "wunderbar";
            $_SESSION['userSession'] = $row['id'];

        } else {

            echo "Email oder Passwort sind falsch oder existieren nicht";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
