<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return response(Role::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = [];
      $data['role'] = Role::Create($request->all());
      if($request->permissions) {
        foreach($request->permissions as $permission) {
          $data['role']['permissions'][] = new Permission($permission);
        }  
        $data['role']->permissions()->saveMany($data['role']['permissions']);
      }

      return response($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
      $role->name = $request->name;
      $role->slug = $request->slug;
      $role->save();

      return response($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
      $role->delete();
      
      return response(["message" => "eliminado: ".$role->name]);
    }
}