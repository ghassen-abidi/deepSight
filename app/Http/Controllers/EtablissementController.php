<?php

namespace App\Http\Controllers;

use App\Models\etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        //get all etablissements
        $etablissements = etablissement::all();
        return response()->json($etablissements);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //create etabliissement 
        $etablissement = etablissement::create([
            'nom' => request('nom'),
            'adresse' => request('adresse'),
            'tel' => request('tel'),
            'email' => request('email'),
            'logo' => request('logo'),
            'status' => request('status'),
            'annee_scolaire' => request('annee_scolaire'),
        ]);
        return response()->json($etablissement);

    }

    public function show(etablissement $etablissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(etablissement $etablissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, etablissement $etablissement)
    {
        //update etablissement 
        $etablissement->update($request->all());
        return response()->json($etablissement);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(etablissement $etablissement)
    {
        //delete etablissement 
        $etablissement->delete();
        return response()->json(null, 204);
        
    }
}
