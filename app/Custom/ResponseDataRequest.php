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
    $this->response['state']    = '0';
    $this->response['message']  = '';
    $this->response['data']     = null;
  }

  //
  public function setResponse(string $state, string $message, object $data = null)
  {
    $this->response['state']    = $state;
    $this->response['message']  = $message;
    $this->response['data']     = $data;
  }

  //
  public function getJson()
  {
    return json_encode($this->response);
  }
}