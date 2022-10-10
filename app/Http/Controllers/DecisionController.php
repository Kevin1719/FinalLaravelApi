<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class DecisionController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * 
     * @return json
     */
    public function autorise(Request $request, int $id)
    {
        //uri = api/candidats/decision/{}/validate?classe=..

        $classe = $request->query('classe');
        Candidat::findOrFail($id)->update([
            'entretien' => 1,
            'classeEnCours' => $classe,
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    /**
     * @param int $id
     * 
     * @return json
     */
    public function refused(int $id)
    {
        Candidat::FindOrFail($id)->update([
            'entretien' => 0,
        ]);
        return response()->json([
            'success' => 1,
        ]);
    }
}
