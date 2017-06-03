<?php
/*
Die Ausfuehrung der Login-Anfrage
====================================
*/
session_start();
require_once 'dbconn.php';

if (isset($_POST['btn-login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password = md5($password);

    try {

        $stmt = $DBcon->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(array(":email" => $email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

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
