<?php

namespace App\Http\Controllers;

use App\Models\Niv;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * 
     * @return json
     */
    public function inscription(Request $request, int $id)
    {
        //uri = api/candidats/{}/inscription?groupe=..
        $groupe = $request->query('groupe');
        $candidat = Candidat::findOrFail($id);
        // return [
        //     'candidat' => $candidat
        // ];
        Niv::create([
            'annee' => $candidat->anneeCandidature,
            'classe' => $candidat->classeEnCours,
            'candidat_id' => $candidat->id,
            'groupe' => $groupe,
        ]); 
        $prenom = [];
        $prenom[] = explode(" ",$candidat->prenom);
        // return [ 
        //     $candidat->penom,
        //     $prenom
        // ];
        $candidats = Candidat::all();
        $emails = [];
        foreach($candidats as $can){
            $emails[] = $can->email;
        }
        $nbr = count($prenom);
        if($nbr == 0){
            $tempEmail = $candidat->nom."@esti.mg";
            if(in_array($tempEmail, $emails)){
                $newEmail = $candidat->nom.".p".date('y')."@esti.mg";
            } else {
                $newEmail = $tempEmail;
            }
        } else {
            $pren = $prenom[0][0];
            $tempEmail = $pren.".".$candidat->nom."@esti.mg";
            if(in_array($tempEmail,$emails)){
                $newEmail = $pren."p".date('y').".".$candidat->nom."@esti.mg";
            } else {
                $newEmail = $tempEmail;
            }
        }
        $candidat->update([
            'status' => 'En cours',
            'email' => strtolower($newEmail),
            'matricule' => MatriculeController::matricule($candidat),
        ]);
       

        return response()->json([
            'success' => 1,
        ]);       
    }
}
