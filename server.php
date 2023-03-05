<?php 
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "datatables";

    
    try{
       
    
        $conn = new PDO("mysql:host=$dbHost;dbName=" . $dbName, $dbUser, $dbPassword);
        
}
    catch(PDOException $err){
        
    }

?>