<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return response(User::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
      return response($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
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