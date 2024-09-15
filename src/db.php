<?php
function connectDB()
{
    $servername="db";
    $user="admin";
    $pass="grannskapet";
    $dbname="grannskapet";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
    
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return null;
}


?>