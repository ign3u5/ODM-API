<?php
require_once "ResponseHandler.php";

function NewJsonObjectRequest($objectValidator)
{
    if (!file_get_contents("php://input"))
        return NewResponse(400, "No payload in request");

    $validatePayloadResponse = $objectValidator(json_decode(file_get_contents("php://input"), true));
    if ($validatePayloadResponse->IsFail())
        return $validatePayloadResponse;

    return NewResponseWithPayload(200, "Request created", $validatePayloadResponse->payload);
}

function NewJsonParamRequest($paramName)
{
    if (!file_get_contents("php://input"))
        return NewResponse(400, "No payload in request");

    $jsonPayload = json_decode(file_get_contents("php://input"), true);
    if (!isset($jsonPayload[$paramName]))
        return NewResponse(400, "Invalid request params"); 

    return NewResponseWithPayload(200, "Request created", $jsonPayload[$paramName]);
}

function NewGetRequest($paramName)
{
    if (!isset($_GET[$paramName]))
        return NewResponse(400, "Invalid request params");
    return NewResponseWithPayload(200, "Request created", $_GET[$paramName]);
}

function IsOptionsRequest()
{
    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS")
    {
        return NewResponse(200, "Options request response");
    }
    return NewResponse(400, "Not options request");
}
?>