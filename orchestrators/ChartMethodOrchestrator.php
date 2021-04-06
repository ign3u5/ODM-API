<?php
    require_once __DIR__."/../handlers/RequestHandler.php";
    require_once __DIR__."/../handlers/ResponseHandler.php";
    require_once __DIR__."/../controllers/DataController.php";
    require_once __DIR__."/../models/Queries.php";

    class ChartMethodOrchestrator
    {
        private $dataController;

        public function __construct()
        {
            $database = new Database();
            $connection = $database->getConnection();
            $this->dataController = new DataController($connection);
        }

        public function Handle()
        {
            if (!IsOptionsRequest()->IsFail())
                return IsOptionsRequest();

            if ($_SERVER['REQUEST_METHOD'] == "GET")
            {
                $getRequestResponse = NewGetRequest("ChartName");
                if ($getRequestResponse->IsFail())
                    return NewResponse(400, "No ChartName request param set");
                
                $sqlQueryResponse = GetQuery($getRequestResponse->payload);
                if ($sqlQueryResponse->IsFail())
                    return $sqlQueryResponse;

                $statementBuilder = $this->dataController->BeginStatement($sqlQueryResponse->payload);

                $limitParamResponse = NewGetRequest("Limit");
                if (!$limitParamResponse->IsFail())
                    $statementBuilder = $statementBuilder->AddLimit($limitParamResponse->payload);
                
                $constraintParamResponse = NewGetRequest("WhereConstraint");
                if (!$constraintParamResponse->IsFail())
                    $statementBuilder = $statementBuilder->AddWhereConstraintValue($constraintParamResponse->payload);
                
                return $statementBuilder->Execute();
            }
            
            return NewResponse(400, "Invalid request method");
        }
    }
?>