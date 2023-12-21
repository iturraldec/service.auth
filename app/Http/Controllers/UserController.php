<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Http\Controllers\Request;
use App\Custom\ResponseDataRequest;
use App\Models\User;

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
    public function index()
    {
      $this->_response->setResponse('1', 'Listado de Ususarios.', User::orderBy('name')->get());

      return response($this->_response->getJson(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // faltan las validaciones correspondientes

      // falta codigo para agregar los roles que tendra el usuario

      $user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password)
			]);
      
      return response($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
      $user->roles;

      return response($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
      // faltan las validaciones correspondientes

      // falta codigo para agregar los roles que tendra el usuario

      $user->name = $request->name;
      $user->email = $request->email;
      if($request->password) {
        $user->password = Hash::make($request->password);
      }
      $user->save();

      return response($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
      $user->delete();
      
      return response(["mensagge" => "usuario eliminado"]);
    }
}