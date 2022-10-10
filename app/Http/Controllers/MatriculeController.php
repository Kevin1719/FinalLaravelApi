<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Matricule;
use Illuminate\Http\Request;

class MatriculeController extends Controller
{
    static function matricule(Candidat $candidat)
    {
        $matricule = '';
        if(strtolower($candidat->genre) == 'g'){
            $matricule = 'FIG';
        } elseif (strtolower($candidat->genre) == 'f'){
            $matricule = 'FIF';
        }
        $mat = Matricule::where('annee',date('y'))->first();
        if(is_null($mat)){
            $number = 1;
            Matricule::create([
                'annee' => date('y'),
                'classe' => $candidat->classeEnCours,
                'number' => 2
            ]);
        } else {
            $number = $mat->number;
            $mat->update([
                'number' => $number + 1,
            ]);
        }
        $matricule = $matricule.''.date('y').''.date('m').'-'.str_pad($number,3,0,STR_PAD_LEFT);
              
        return $matricule;
    }
}
