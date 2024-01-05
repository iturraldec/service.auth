<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Custom\ResponseDataRequest;
use App\Models\Permission;

class PermissionController extends Controller
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
      $this->_response->setResponse('1', 'Listado de permisos, paginados.', Permission::orderBy('name')->paginate(5));
    }
    else {
      $this->_response->setResponse('1', 'Listado de permisos.', Permission::orderBy('name')->get());
    }

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // faltan las validaciones correspondientes

    $permission = Permission::create([
      'name' => $request->name,
      'slug' => $request->slug
    ]);
    $this->_response->setResponse('1', 'Permiso creado.', $permission);
    
    return response($this->_response->response, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   */
  public function show(Permission $permission)
  {
    $permission->roles;
    $this->_response->setResponse('1', 'Permiso.', $permission);

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Permission $permission)
  {

    // faltan las validaciones correspondientes

    $permission->name = $request->name;
    $permission->slug = $request->slug;
    $permission->save();
    $this->_response->setResponse('1', 'Permiso modificado.', $permission);

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Permission $permission)
  {
    $permission->delete();
    $this->_response->setResponse('1', 'Permiso eliminado.');
    
    return response($this->_response->response, Response::HTTP_OK);
  }
}