<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Custom\ResponseDataRequest;
use App\Models\Role;
use stdClass;

class RoleController extends Controller
{
  private $_response;

  public function __construct()
  {
    $this->_response = new ResponseDataRequest();
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if($request->page) {
      $this->_response->setResponse('1', 'Listado de roles, paginados.', Role::orderBy('name')->with('permissions')->paginate(5));
    }
    else {
      $this->_response->setResponse('1', 'Listado de roles.', Role::with('permissions')->get());
    }

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = new stdClass();
    $data->role = Role::Create($request->all());
    if($request->permissions) {
      $data->permissions = $data->role->permissions()->sync($request->permissions);
    }

    $this->_response->setResponse('1', 'Rol creado.', $data);

    return response($this->_response->response, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   */
  public function show(Role $role)
  {
    $role->permissions;
    $data['role'] = $role;

    return response(['data' => $data]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Role $role)
  {
    // faltan las validaciones

    $role->name = $request->name;
    $role->slug = $request->slug;
    $role->save();

    if($request->permissions) {
      $role->permissions()->sync($request->permissions);
    }

    $this->_response->setResponse('1', 'Rol actualizado.', $role);

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Role $role)
  {
    $role->delete();
    $this->_response->setResponse('1', 'Rol eliminado.');
    
    return response($this->_response->response, Response::HTTP_OK);
  }
}