<?php
    require_once __DIR__."/../models/Database.php";
    require_once __DIR__."/../handlers/ResponseHandler.php";

    class DataController{
        private $connection;
        private $statement;

        public function __construct($database) {
            $this->connection = $database;
        }

        function BeginStatement($query) {
            $this->statement = $this->connection->prepare($query);
            return $this;
        }

        public function AddLimit($limit)
        {
            $this->statement->bindParam(":limit", $limit, PDO::PARAM_INT);
            return $this;
        }
    
        public function AddWhereConstraintValue($constraintValue)
        {
            $this->statement->bindParam(":constraint", $constraintValue);
            return $this;
        }
    
        public function Execute()
        {
            if ($this->statement->execute())
			{
				$result = $this->statement->fetchAll(PDO::FETCH_NUM);
				return NewResponseWithPayload(200, "Successfully collected data for total show type", $result);
			}

            return RespondWithDatabaseExecutionError();
        }
    }
?>