<?php
$filenameArray = [];

$handle = opendir(dirname(realpath(__FILE__)).'/images/');
     while($file = readdir($handle)){
         if($file !== '.' && $file !== '..'){
             array_push($filenameArray, "images/$file");
         }
     }

echo json_encode($filenameArray);
?>
