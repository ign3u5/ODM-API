<?php
    header("Access-Control-Allow-Origin: *");   
    header("Content-Type: application/json; charset=UTF-8");    
    header("Access-Control-Allow-Methods: GET, OPTIONS");    
    header("Access-Control-Max-Age: 3600");    
    header("Access-Control-Allow-Headers: Content-Type, content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With");  
    require_once "orchestrators/ChartMethodOrchestrator.php";
    require_once "handlers/ResponseHandler.php";
    
    $chartMethodOrchestrator = new ChartMethodOrchestrator();
    $chartMethodOrchestrator->Handle()->SendResponse();
?>
