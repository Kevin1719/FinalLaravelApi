<?php

namespace App\Http\Controllers;

use App\Models\Preparatoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreparatoiresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Preparatoire::where('validation', 1)->get();
    }

    public function listePrepaInscriOnligne()
    {
        return Preparatoire::where('validation', null)->get();
    }

    public function validation($id)
    {
        $prep = Preparatoire::findOrFail($id);
        $prep->update(['validation' => 1]);
    }

    public function refus($id)
    {
        $prep = Preparatoire::findOrFail($id);
        $prep->update(['validation' => 0]);
    }
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
            'email' => ['required', 'email'],
            'serie' => ['required'],
            'niveau' => ['required'],
            'adresse' => ['required'],
            'contact' => ['required','numeric'],
            'genre' => ['required'],
            'bordereauDeDonnee' => ['file']
        ]);
        if($vs->fails()){
            return response()->json([
                'validate_err' => $vs->messages(), //aza raraina fa mande fona io
            ]);
        } else {
            if($request->hasFile('bordereauDeDonnee')){
                $path = 'public/dossier/'.$request->nom;
                $image_name = $request->file('bordereauDeDonnee')->getClientOriginalName();
                $chemin = $request->file('bordereauDeDonnee')->storeAs($path,$image_name);
            }

            $prep = Preparatoire::create($request->all());
            $prep->update([
                'bordereauDeDonnee' => $chemin,
                'annee' => date('Y'),
                'mois' => date('m'),
            ]);
            return response()->json([
                'success' => 'Inscription reussie',
            ], 200);
        }
    }

    public function storeAdmin(Request $request)
    {
        $vs = Validator::make($request->all(),[
            'nom' => ['required'],
            'email' => ['required', 'email'],
            'serie' => ['required'],
            'niveau' => ['required'],
            'adresse' => ['required'],
            'contact' => ['required','numeric'],
            'genre' => ['required'],
            'bordereauDeDonnee' => ['file']
        ]);
        if($vs->fails()){
            return response()->json([
                'validate_err' => $vs->messages(), //aza raraina fa mande fona io
            ]);
        } else {
            if($request->hasFile('bordereauDeDonnee')){
                $path = 'public/dossier/'.$request->nom;
                $image_name = $request->file('bordereauDeDonnee')->getClientOriginalName();
                $chemin = $request->file('bordereauDeDonnee')->storeAs($path,$image_name);
            }

            $prep = Preparatoire::create($request->all());
            $prep->update(['bordereauDeDonnee' => $chemin, 'validation' => 1]);
            return response()->json([
                'success' => 'Inscription reussie',
            ], 200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Preparatoire $preparatoire
     * @return \Illuminate\Http\Response
     */
    public function show(Preparatoire $preparatoire)
    {
        return $preparatoire;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Preparatoire $preparatoire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preparatoire $preparatoire)
    {
        $request->validate([
            'nom' => ['required'],
            'contact' => ['required'],
            'mois' => ['required'],
        ]);

        $preparatoire->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'mois' => $request->mois,
            'contact' => $request->contact,
        ]);

        return response()->json([
            "success" => '1'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Preparatoire $preparatoire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preparatoire $preparatoire)
    {
        $preparatoire->delete();

        return response()->json([
            "success" => '1'
        ], 200);
    }
}
