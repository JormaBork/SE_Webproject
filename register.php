<?php

require_once 'dbconn.php';

if($_POST)
{
    $name 		= trim($_POST['user_name']);
    $email 	= trim($_POST['user_email']);
    $pass 	= trim($_POST['user_password']);
    $password = md5($pass);



    try
    {
      // Pruefe ob Email existiert
      $stmt_select = $DBcon->prepare("SELECT * FROM users WHERE email=:email");
      $stmt_select->execute(array(":email"=>$email));
      $count = $stmt_select->rowCount();


        // Wenn der Count 0 ist die Mail noch nicht vergeben
        if($count==0){
            $stmt = $DBcon->prepare("INSERT INTO users(name,email,password) VALUES(:uname, :email, :pass)");
            $stmt->bindParam(":uname",$name);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":pass",$password);

            if($stmt->execute())
            {
                echo "registriert";
            }
            else
            {
                echo "konnte nicht ausgefuehrt werden";
            }

        }
        else{
            // nicht Verfügbar wenn die Email bereits vorhanden ist
            echo "1";
        }

    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}

?>
