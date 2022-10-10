<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class ConcoursController extends Controller
{
    /**
     * @param int $id
     * 
     * @return json
     */
    public function autorise(int $id)
    {
        Candidat::findOrFail($id)->update([
            'concours' => 1,
        ]);
        return response()->json([
            'success' => 1
        ], 200);
    }
    /**
     * @param int $id
     * 
     * @return json
     */
    public function refused(int $id)
    {
        Candidat::findOrFail($id)->update([
            'concours' => 0,
        ]);
        return response()->json([
            'success' => 1
        ], 200);
    }
}
