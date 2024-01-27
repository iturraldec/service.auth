<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Custom\ResponseDataRequest;
use App\Models\User;
use stdClass;

class UserController extends Controller
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
      $this->_response->setResponse('1', 'Listado de usuarios, paginados.', User::orderBy('name')->with('roles')->paginate(15));
    }
    else {
      $this->_response->setResponse('1', 'Listado de usuarios.', User::with('roles')->get());
    }
    
    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // faltan las validaciones correspondientes
    
    $data = new stdClass();
    $data->user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password)
    ]);

    if($request->roles) {
      $data->roles = $data->user->roles()->sync($request->roles);
    };

    $this->_response->setResponse('1', 'Ususario creado.', $data);
    
    return response($this->_response->response, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    $user->roles;
    $this->_response->setResponse('1', 'Ususario.', $user);

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    // faltan las validaciones correspondientes

    $user->name = $request->name;
    $user->email = $request->email;
    if(strlen($request->password) > 0) {
      $user->password = $request->password;
    }

    $user->save();

    if(count($request->roles) == 0) {
      $user->roles()->detach();
    }
    else {
      $user->roles()->sync($request->roles);
    }

    $this->_response->setResponse('1', 'Ususario modificado.', $user);

    return response($this->_response->response, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $user->delete();
    $this->_response->setResponse('1', 'Ususario eliminado.');
    
    return response($this->_response->response, Response::HTTP_OK);
  }
}