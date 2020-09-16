<?php
     namespace DataAccess;

     class DatabaseConnection{

        private $username ="";
        private $password ="";
        private $host ="";
        public $dbConnection = null;
        function __construct($username,$password,$host="localhost"){
            $this->username = $username;
            $this->password = $password;
            $this->host = $host;
        }

       public function connect(){
            $this->dbConnection = new \PDO("mysql:host={$this->host}",$this->username,$this->password);
            return $this->dbConnection;
        }

       public function createDatabase($databaseName){
            //create connection if it does not exist
            if($this->dbConnection==null){
                $this->connect();
            }

            $query = "create database if not exists {$databaseName}";
            $stmt = $this->dbConnection->prepare($query);
           return  $stmt->execute();
        }

        public function createTable($tableName){
            if($this->dbConnection==null){
                $this->connect();
            }

            $query = "use {$this->databaseName};create table if not exists {$tableName}(
                    id int primary key auto_increment, 
                    description varchar(50),
                    completed tinyint,
                    datetimestamp datetime not null default current_timestamp
            );";

            $stmt = $this->dbConnection->prepare($query);
            return $stmt->execute();
        }
     }
?>