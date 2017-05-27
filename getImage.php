<?php




require_once 'database.php';

//Arrays
$dbArray = array();
$dirFilesArray = array();


//fetch table rows from mysql db
    $sql = "select filename from memes";
    $result = mysqli_query($DBcon, $sql) or die("Error in Selecting " . mysqli_error($DBcon));


    // $handle = opendir(dirname(realpath(__FILE__)).'/images/');
    // while($file = readdir($handle)){
    //      if($file !== '.' && $file !== '..'){
    //          array_push($dirFilesArray, $file);
    //      }
    //  }


    while($row =mysqli_fetch_row($result))
    {
        array_push($dbArray, $row);

    }

  echo json_encode($dbArray);






    //close the db connection
    mysqli_close($DBcon);

?>
