<?php
    require_once("./DataAccess/DbConnection.php");
    use \DataAccess\DatabaseConnection;

    $userName = "etiocioh_etiocioh";
    $pass = "i+i!xzU[1azu";
    $databaseName ="todosDatabase"; 
    $dbConnector = new DatabaseConnection($userName,$pass); //connects to local mysql server
    $dbCreated = $dbConnector->createDatabase($databaseName); //creates the database if it doesn't already exist
    $toDoTableCreated  = $dbConnector->createTable("todos"); //creates table if it doesn't already exist
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