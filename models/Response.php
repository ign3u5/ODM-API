<?php

abstract class Response
{
    protected $statusCode;
    protected $message;
    protected $responseContent;
    public function __construct($statusCode, $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->responseContent = array();
    }
    abstract public function IsFail();
    protected function CreateResponseContent()
    {
        $this->responseContent["message"] = $this->message;
    }
    public function SendResponse()
    {
        $this->CreateResponseContent();
        http_response_code($this->statusCode);
        echo json_encode($this->responseContent);
    }
}

abstract class ResponseWithPayload extends Response
{
    public $payload;
    public function __construct($statusCode, $message, $payload)
    {
        parent::__construct($statusCode, $message);
        $this->payload = $payload;
    }
    protected function CreateResponseContent()
    {
        $this->responseContent["message"] = $this->message;
        $this->responseContent["data"] = $this->payload;
    }
}

class SuccessResponse extends Response
{
    public function IsFail()
    {
        return false;
    }
}
class SuccessResponseWithPayload extends ResponseWithPayload
{
    public function IsFail()
    {
        return false;
    }
}
class FailResponse extends Response
{
    public function IsFail()
    {
        return true;
    }
}
class FailResponseWithPayload extends ResponseWithPayload
{
    public function IsFail()
    {
        return true;
    }
}
?>