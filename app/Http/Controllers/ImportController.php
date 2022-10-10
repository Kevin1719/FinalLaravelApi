<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatsImport;
use App\Imports\InscriptionsImport;
use App\Imports\PreparatoiresImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function store(Request $request)
    {



        if($request->hasFile('coursPrepa')){
            
            $courPrepa = $request->file('coursPrepa')->store('temp');
            
            Excel::import(new PreparatoiresImport, $courPrepa);
        }

        if($request->hasFile('etudiantsESTI')){
            $etudiantEsti = $request->file('etudiantsESTI')->store('temp');

            Excel::import(new CandidatsImport, $etudiantEsti);
        }

        if($request->hasFile('candidatsESTI')){
            $candidatsEsti = $request->file('candidatsESTI')->store('temp');

            Excel::import(new InscriptionsImport, $candidatsEsti);
        }
        
        return response()->json(['success' => 1]);
    }
}
