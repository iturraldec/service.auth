<?php

namespace App\Custom;

//
class ResponseDataRequest
{
  //
  public $response = null;

  //
  public function __construct()
  {
    $this->response['status']   = '0';
    $this->response['message']  = '';
    $this->response['data']     = null;
  }

  //
  public function setResponse(string $status, string $message, object $data = null)
  {
    $this->response['status']   = $status;
    $this->response['message']  = $message;
    $this->response['data']     = $data;
  }

  //
  public function getJson()
  {
    return json_encode($this->response);
  }
}