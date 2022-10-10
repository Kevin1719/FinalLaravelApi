<?php

namespace App\Http\Controllers;

use App\Models\L2Model;
use Illuminate\Http\Request;

class L2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $listes = L2Model::all();
        foreach($listes as $liste){
            $data[] = [
                // 'candidat'=>$liste->candidat,
                "id"=> $liste->candidat->id,
                "nom"=> $liste->candidat->nom,
                "prenom"=> $liste->candidat->prenom,
                "serie"=> $liste->candidat->serie,
                "nationalite"=> $liste->candidat->nationalite,
                "situationFamiliale"=> $liste->candidat->situationFamiliale,
                "contact"=> $liste->candidat->contact,
                "nombreEnfant"=> $liste->candidat->nombeEnfant,
                "adresse"=> $liste->candidat->adresse,
                "email"=> $liste->candidat->email,
                "dateDeNaissance"=> $liste->candidat->dateDeNaissance,
                "lieuDeNaissance"=> $liste->candidat->lieuDeNaissance,
                "postule"=> $liste->candidat->postule,
                "genre"=> $liste->candidat->genre,
                "concours"=> $liste->candidat->concours,
                "entretien"=> $liste->candidat->entretien,
                "status"=> $liste->candidat->status,
                "anneeCandidature"=> $liste->candidat->anneeCandidature,
                "matricule"=> $liste->candidat->matricule,
                "nomPere"=> $liste->candidat->nomPere,
                "nomMere"=> $liste->candidat->nomMere,
                "nomTuteur"=> $liste->candidat->nomTuteur,
                "professionPere"=> $liste->candidat->professionPere,
                "professionMere"=> $liste->candidat->professionMere,
                "professionTuteur"=> $liste->candidat->PofessionTuteur,
                "telPere"=> $liste->candidat->telPere,
                "telMere"=> $liste->candidat->telMere,
                "telTuteur"=> $liste->candidat->telTuteur,
                "finish"=> $liste->candidat->finish,
                "abandon"=> $liste->candidat->abandon,
                "finishL3"=> $liste->candidat->finishL3,
                "selectedDiplome"=> $liste->candidat->selectedDiplome,
                "selectedReleveDeNoteBacc"=> $liste->candidat->selectedReleveDeNoteBacc,
                "selectedReleveDeNoteSeconde"=> $liste->candidat->selectedReleveDeNoteSeconde,
                "selectedReleveDeNotePremiere"=> $liste->candidat->selectedReleveDeNotePremiere,
                "selectedReleveDeNoteTerminale"=> $liste->candidat->selectedReleveDeNoteTerminale,
                "certificatDeResidance"=> $liste->candidat->certificatDeResidance,
                "selectedPhoto"=> $liste->candidat->selectedPhoto,
                "selectedCINorCIS"=> $liste->candidat->selectedCINorCIS,
                "cv"=> $liste->candidat->v,
                "bordereauEsti"=> $liste->candidat->bordereauEsti,
                "parcours"=> $liste->candidat->parcours,
                "nbrStage"=> $liste->candidat->nbrStage,
                "entrepriseStage"=> $liste->candidat->entrepriseStage,
                "nbrAlternance"=> $liste->candidat->nbrAlternance,
                "entrepriseAlternance"=> $liste->candidat->entrepriseAlternance,
                "travauxPerso"=> $liste->candidat->travauxPerso,
                "activiteParaPro"=> $liste->candidat->activiteParaPro,
                'annee' => $liste->anneeUniversitaire,
                'groupe' => $liste->groupe,
                'statusEnL2' => $liste->status            ]; 
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\L2Model  $l2Model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, L2Model $l2Model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $candidat = L2Model::where('candidat_id',$id)->firstOrFail();
        ($candidat->delete()) ? $reponse = response()->json(['success' => 1],200) : $reponse = response()->json(['success' => 0],200);
        return $reponse;
    }
}
