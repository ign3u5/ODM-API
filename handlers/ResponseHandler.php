<?php
require_once __DIR__."/../models/Response.php";

function NewResponse($statusCode, $message)
{
    if ($statusCode > 399)
        return new FailResponse($statusCode, $message);
    return new SuccessResponse($statusCode, $message);
}

function NewResponseWithPayload($statusCode, $message, $payload)
{
    if ($statusCode > 399)
        return new FailResponseWithPayload($statusCode, $message, $payload);
    return new SuccessResponseWithPayload($statusCode, $message, $payload);
}
?>