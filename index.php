<?php
    require_once("./DataAccess/DbConnection.php");
    use \DataAccess\DatabaseConnection;

    $userName = "zone4got_mysqluser";
    $pass = "OB?vC{@q_lNm";
    $databaseName ="zone4got_todosDatabase"; 
    $host = "154.0.171.142";
    $dbConnector = new DatabaseConnection($userName,$pass,$host); //connects to local mysql server
    $dbCreated = $dbConnector->createDatabase($databaseName); //creates the database if it doesn't already exist
    $toDosTableName = "todos";
    $toDoTableCreated  = $dbConnector->createTable($toDosTableName,$databaseName); //creates table if it doesn't already exist
    $databaseConnection = $dbConnector->dbConnection; //get connection to database
    
    //function to retrieve to do items
    function getToDos($dbConnection,$toDosTableName){
        $query = "select id, description,completed from {$toDosTableName}";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    //function to add a to do item
    function addToDo($dbConnection,$toDosTableName,$toDoItem){
        if(!isset($toDoItem["description"]) || !isset($toDoItem["completed"])){
             return 0;
        }
        $query = "insert into {$toDosTableName}(description,completed) values(:descr,:completed)";
        $stmt = $dbConnection->prepare($query);
       
       return $stmt->execute([
            ":descr"=>$toDoItem["description"],
            ":completed"=>$toDoItem["completed"]
        ]);
    }

    function removeToDo($dbConnection,$toDosTableName,$toDoId){
        $query = "delete from {$toDosTableName} where id = :id";
        $stmt = $dbConnection->prepare($query);
        return $stmt->execute([":id"=>$toDoId]);
    }

    function updateToDoStatus($dbConnection,$toDosTableName,$status,$toDoId){
        $query = "update {$toDosTableName} set completed=:status where id=:id";
        $stmt = $dbConnection->prepare($query);
        return $stmt->execute([":status"=>$status,":id"=>$toDoId]);
    }

    //

    //print_r(addToDo($databaseConnection,$toDosTableName,["description"=>"Clean garage","completed"=>true]));
    //print_r(updateToDoStatus($databaseConnection,$toDosTableName,false,1));
    print_r(getToDos($databaseConnection,$toDosTableName));
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