<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Custom\ResponseDataRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use stdClass;

class DashboardController extends Controller
{
  private $_response;

  public function __construct()
  {
    $this->_response = new ResponseDataRequest();
  }

  public function users()
  {
    $data = new stdClass();
    $data->data = array(
      array('concepto' => 'Permisos','cantidad'  => Permission::count()),
      array('concepto' => 'Roles','cantidad'  => Role::count()),
      array('concepto' => 'Usuarios activos','cantidad'  => User::where('is_asset', true)->count()),
      array('concepto' => 'Usuarios inactivos','cantidad'  => User::where('is_asset', false)->count()),
    );

    $this->_response->setResponse('1', 'Dashboard.', $data);

    return response($this->_response->response, Response::HTTP_OK);
  }
}