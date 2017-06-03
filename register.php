<?php
/*
Die Ausfuehrung der Registrierungs-Anfrage
==========================================
Die register.php empfaegt die übermittelteten Daten
und prueft, ob die E-Mail bereits existiert. Ist dies
nicht der Fall kann die Registrierung ausgefuehrt werden.
Andernfalls wird eine Fehlermeldung ausgegeben. Sollte
die E-Mail bereits existieren, wird eine seperate Meldung
ausgegeben. Die entsprechendes "echo's" werden von der
"Uebermittlungs-Funktion" der register.js ausgewertet.
*/
require_once 'dbconn.php';

if ($_POST) {
    $name = trim($_POST['user_name']);
    $email = trim($_POST['user_email']);
    $pass = trim($_POST['user_password']);
    $password = md5($pass);

    // Try und Catch Block fuer besseres Error Handling.
    try {
        // Pruefe ob Email existiert
        $stmt_select = $DBcon->prepare("SELECT * FROM users WHERE email=:email");
        $stmt_select->execute(array(":email" => $email));
        $count = $stmt_select->rowCount();


        // Wenn der Count 0 ist die Mail noch nicht vergeben.
        if ($count == 0) {
            $stmt = $DBcon->prepare("INSERT INTO users(name,email,password) VALUES(:uname, :email, :pass)");
            $stmt->bindParam(":uname", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pass", $password);

            // Aufuehrung des Statements
            if ($stmt->execute()) {
                echo "registriert";
            // Fehlermeldung falls der Vorgang nicht ausgefuehrt werden konnte. 
            } else {
                echo "konnte nicht ausgefuehrt werden";
            }

        } else {
            // nicht Verfügbar wenn die Email bereits vorhanden ist
            echo "1";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
