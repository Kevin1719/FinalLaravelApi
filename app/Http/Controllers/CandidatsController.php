<?php

namespace App\Http\Controllers;


use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Candidat::all();
    }

    public function listeEtudiants()
    {
        return Candidat::where('candidats.status', '<>', null)->join('nivs', 'nivs.candidat_id', '=', 'candidats.id')
            ->select('candidats.*','nivs.annee', 'nivs.groupe', 'nivs.classe')
            ->get();
    }

    public function listeCandidatures()
    {
        return Candidat::where('status',null)->where('entretien',null)->get();
    }

    // public function showAllCandidatAt($annee)
    // {
    //     return Candidat::where('anneeCandidature',$annee)->get();
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(),[
            'nom' => ['required'],
            'email' => ['unique:candidats'],
            'dateDeNaissance' => ['required'],
            'lieuDeNaissance' => ['required'],
            'nationalite' => ['required'],
            'situationFamiliale' => ['required'],
            'adresse' => ['required'],
            'contact' => ['required'],
            'serie' => ['required'],
            'postule' => ['required'],
            'genre' => ['required'],
         ]);
        if($vs->fails()){
            return response()->json([
                'validate_err' => $vs->messages(),//aza rarahina fa mandeh hiany io
            ]);
        } else {
            $diplome = null;
            $rlvBacc = null;
            $rlvSeconde = null;
            $rlvPremiere = null;
            $rlvTerminale = null;
            $certificatDeResidence = null;
            $selectedPhoto = null;
            $selectedCINorCIS = null;
            $cv = null;
            $bordereauEsti = null;

            if($request->hasFile('selectedDiplome')){
                $path = 'public/dossier/Diplome/'.$request->nom;
                $image_name = $request->file('selectedDiplome')->getClientOriginalName();
                $diplome = $request->file('selectedDiplome')->storeAs($path,$image_name);
            }

            if($request->hasFile('selectedReleveDeNoteBacc')){
                $path = 'public/dossier/rlvBacc/'.$request->nom;
                $image_name = $request->file('selectedReleveDeNoteBacc')->getClientOriginalName();
                $rlvBacc = $request->file('selectedReleveDeNoteBacc')->storeAs($path,$image_name);
            }


            if($request->hasFile('selectedReleveDeNoteSeconde')){
                $path = 'public/dossier/rlvSeconde/'.$request->nom;
                $image_name = $request->file('selectedReleveDeNoteSeconde')->getClientOriginalName();
                $rlvSeconde = $request->file('selectedReleveDeNoteSeconde')->storeAs($path,$image_name);
            }

            if($request->hasFile('selectedReleveDeNotePremiere')){
                $path = 'public/dossier/rlvPremiere/'.$request->nom;
                $image_name = $request->file('selectedReleveDeNotePremiere')->getClientOriginalName();
                $rlvPremiere = $request->file('selectedReleveDeNotePremiere')->storeAs($path,$image_name);
            }

            if($request->hasFile('selectedReleveDeNoteTerminale')){
                $path = 'public/dossier/rlvTerminale/'.$request->nom;
                $image_name = $request->file('selectedReleveDeNoteTerminale')->getClientOriginalName();
                $rlvTerminale = $request->file('selectedReleveDeNoteTerminale')->storeAs($path,$image_name);
            }

            if($request->hasFile('certificatDeResidence')){
                $path = 'public/dossier/certificatDeResidence/'.$request->nom;
                $image_name = $request->file('certificatDeResidence')->getClientOriginalName();
                $certificatDeResidence = $request->file('certificatDeResidence')->storeAs($path,$image_name);
            }

            if($request->hasFile('selectedPhoto')){
                $path = 'public/dossier/selectedPhoto/'.$request->nom;
                $image_name = $request->file('selectedPhoto')->getClientOriginalName();
                $selectedPhoto = $request->file('selectedPhoto')->storeAs($path,$image_name);
            }

            if($request->hasFile('selectedCINorCIS')){
                $path = 'public/dossier/selectedCINorCIS/'.$request->nom;
                $image_name = $request->file('selectedCINorCIS')->getClientOriginalName();
                $selectedCINorCIS = $request->file('selectedCINorCIS')->storeAs($path,$image_name);
            }

            if($request->hasFile('cv')){
                $path = 'public/dossier/cv/'.$request->nom;
                $image_name = $request->file('cv')->getClientOriginalName();
                $cv = $request->file('cv')->storeAs($path,$image_name);
            }

            if($request->hasFile('bordereauEsti')){
                $path = 'public/dossier/bordereauEsti/'.$request->nom;
                $image_name = $request->file('bordereauEsti')->getClientOriginalName();
                $bordereauEsti = $request->file('bordereauEsti')->storeAs($path,$image_name);
            }
            $candidat = Candidat::create($request->all());

            $candidat->update([
                'anneeCandidature' => date('Y') + 1,
                'selectedDiplome'=> $diplome,
                'selectedReleveDeNoteBacc'=> $rlvBacc,
                'selectedReleveDeNoteSeconde'=> $rlvSeconde,
                'selectedReleveDeNotePremiere'=> $rlvPremiere,
                'selectedReleveDeNoteTerminale'=> $rlvTerminale,
                'certificatDeResidance'=> $certificatDeResidence,
                'selectedPhoto'=> $selectedPhoto,
                'selectedCINorCIS'=> $selectedCINorCIS,
                'cv'=> $cv,
                'bordereauEsti'=> $bordereauEsti,
            ]);
            return response()->json(['success' => 1],200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function show(Candidat $candidat)
    {

        return [
            "id" => $candidat->id,
            'nom' => $candidat->nom,
            "prenom" => $candidat->prenom,
            "photo" => '../assets/Api/public'.Storage::url($candidat->photo),
            "age" => $candidat->age,
            "serie" => $candidat->serie,
            "nationalite" => $candidat->nationalite,
            "situationFamiliale" => $candidat->situationFamiliale,
            "contact" => $candidat->contact,
            "nombreEnfant" => $candidat->nombreEnfant,
            "adresse" => $candidat->adresse,
            "email" => $candidat->email,
            "dateDeNaissance" => $candidat->dateDeNaissance,
            "lieuDeNaissance" => $candidat->lieuDeNaissance,
            "postule" => $candidat->postule,
            "genre" => $candidat->genre,
            "concours" => $candidat->concours,
            "entretien" => $candidat->entretien,
            "classe" => $candidat->classe,
            "status" => $candidat->status,
            "anneeCandidature" => $candidat->anneeCandidature,
            "matricule" => $candidat->matricule,
            "nomPere" => $candidat->nomPere,
            "nomMere" => $candidat->nomMere,
            "nomTuteur" => $candidat->nomTuteur,
            "professionPere" => $candidat->professionPere,
            "professionMere" => $candidat->professionMere,
            "professionTuteur" => $candidat->professionTuteur,
            "telPere" => $candidat->telPere,
            "telMere" => $candidat->telMere,
            "telTuteur" => $candidat->telTuteur,
            "finish" => $candidat->finish,
            "abandon" => $candidat->abandon,
            "finishL3" => $candidat->finishL3,
            "historique" => $candidat->niveaux
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidat $candidat)
    {
        $request->validate([
            'nom' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'adresse' => ['required'],
        ]);

        if($candidat->update($request->all())){
            return response()->json([
                "succes" => "1"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidat $candidat)
    {
        if($candidat->delete()){
            return response()->json([
                "success" => "1"
            ], 200);
        }
    }
    public function maj(Request $request, $id)
    {
        $vs = Validator::make($request->all(),[
            'nom' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'adresse' => ['required'],
         ]);
        if($vs->fails()){
            return response()->json([
                'success' => $vs->messages(),//aza rarahina fa mandeh hiany io
            ]);
        } else {
            Candidat::findOrFail($id)->update($request->all());
            return response()->json([
                'success' => 1,
            ],200);
        }
    }
}
