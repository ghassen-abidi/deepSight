<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        //get all roles
        $roles = role::all();
        return response()->json($roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //create new role 
        $role = new role();
        $role->nom = $request->nom;
        $role->save();
        return response()->json($role);

    }
    
    /**
     * Update the specified resource in storage.
     */
    //function update role
    public function update(Request $request,$id)
    {
        //update role
        $role = role::find($request->id);
        $role->nom = $request->nom;
        $role->save();
        return response()->json($role);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request,$id)
    {
        //delete role
        $role = role::find($id);
        $role->delete();
        return response()->json($role);




    }
}
