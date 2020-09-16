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

    //print_r(addToDo($databaseConnection,$toDosTableName,["description"=>"Clean garage","completed"=>true]));
    //print_r(updateToDoStatus($databaseConnection,$toDosTableName,false,1));
    if(isset($_POST['description']) && isset($_POST["completed"])){
        addToDo($databaseConnection,$toDosTableName,["description"=>$_POST["description"],"completed"=>$_POST["completed"]]);
        
    }
    else if(isset($_POST['deleteToDo'])){
        removeToDo($databaseConnection,$toDosTableName,$_POST['deleteToDo']);
    }
    $toDos = getToDos($databaseConnection,$toDosTableName);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To_Do_List</title>
    <style>
        td{
            padding:0.25em;
            text-align:center;
        }
        .content-container{
            width:80%;
            margin:auto;
            max-width:640px;
        }
        .center-content{
            text-align:center;
        }
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class='content-container center-content'>
    <input name='description' placeholder="description" id='to-do-description'/><button value ='addToDo' type='submit'>Add ToDo</button>
    <input type='hidden' name='completed' value='0'>
    </form>
    <table class='content-container'>
        <thead>
            <tr>
            <th>Description</th>
            <th>Complete</th>
            <th>Action</th></tr>
        </thead>
        <tbody>
            <?php
                $currentPage = $_SERVER['PHP_SELF'];
                foreach($toDos as $todo){
                    $buttonStr = "<button type='submit'>Delete</button>";
                    $deleteInput = "<input type='hidden' name='deleteToDo' value='{$todo["id"]}'/>";
                    $form = "<form method='post' action='{$currentPage}'>{$deleteInput}{$buttonStr}</form>";
                    $checked = $todo['completed']?'checked':null;
                    $checkBox = "<input type='checkbox' {$checked} onchange='toDoCheckedStateChange(this)'>";
                    echo "<tr id='{$todo['id']}'><td>{$todo['description']}</td><td>{$checkBox}</td><td>{$form}</td></tr>";
                }
            ?>
        </tbody>
    </table>
                
</body>
</html>