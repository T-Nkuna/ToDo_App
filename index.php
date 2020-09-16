<?php
    require_once("./DataAccess/DbConnection.php");
    use \DataAccess\DatabaseConnection;

    $userName = "zone4got_mysqluser";
    $pass = "OB?vC{@q_lNm";
    $databaseName ="zone4got_todosDatabase"; 
    $host = "154.0.171.142";
    $dbConnector = new DatabaseConnection($userName,$pass,$host); //connects to local mysql server
    $dbCreated = $dbConnector->createDatabase($databaseName); //creates the database if it doesn't already exist
    $toDoTableCreated  = $dbConnector->createTable("todos",$databaseName); //creates table if it doesn't already exist
    $databaseConnection = $dbConnector->dbConnection; //get connection to database
    exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To_Do_List</title>
</head>
<body>
    
</body>
</html>