<?php
    $servername = "localhost";
    $username = "root";  
    $password = "";      
    $dbname = "employee_management";

    // $servername = "sql307.infinityfree.com";
    // $username = "if0_37538801";  
    // $password = "6OOuH7TyHcu";      
    // $dbname = "if0_37538801_employee_management";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
