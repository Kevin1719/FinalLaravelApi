<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class CandidatsAttenteInscriptionController extends Controller
{
    public function getList()
    {
        return Candidat::where('entretien', 1)->where('status', null)->get();
    }
}
