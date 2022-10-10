<?php

namespace App\Http\Controllers;

use App\Models\L1Model;
use App\Models\L2Model;
use App\Models\L3Model;
use App\Models\M1Model;
use App\Models\M2Model;
use App\Models\Candidat;
use App\Models\Niv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdmissionController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     *
     * @return [type]
     */
    public function admis(Request $request,int $id)
    {
        $groupe = $request->query('groupe');
        $candidat = Candidat::where('id',$id)->firstOrFail();

        if($candidat->classeEnCours == 'L1') {
            $l1 = Niv::where('candidat_id',$id)->orderByDesc('annee')->first();
            $candidat->update([
                'classeEnCours' => 'L2',
            ]);
            Niv::create([
                'annee' => $l1->annee + 1,
                'classe' => 'L2',
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classeEnCours == 'L2'){
            $l2 = Niv::where('candidat_id',$id)->orderByDesc('annee')->first();
            $candidat->update([
                'classeEnCours' => 'L3',
            ]);
            Niv::create([
                'annee' => $l2->annee + 1,
                'classe' => 'L3',
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classeEnCours == 'L3'){
            $l3 = Niv::where('candidat_id',$id)->orderByDesc('annee')->first();
            $candidat->update([
                'classeEncours' => 'M1',
                'finishL3' => 1,
                'status' => 'Licence'
            ]);
            Niv::create([
                'annee' => $l3->annee + 1,
                'candidat_id' => $candidat->id,
                'classe' => 'M1',
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classe == 'M1'){
            $m1 = Niv::where('candidat_id',$id)->orderByDesc('annee')->first();
            $candidat->update([
                'classeEnCours' => 'M2',
            ]);
            Niv::create([
                'annee' => $m1->annee + 1,
                'candidat_id' => $candidat->id,
                'classe' => 'M2',
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }else {
            $candidat->update(['finish' => 1, 'status' => 'Master/Obtenu']);
            $can = Niv::where('candidat_id',$id)->orderByDesc('annee')->firstOrFail();
            $can->update(['status' => 'Master/Obtenu']);
            return response()->json(['success' => 1],200);
        }
    }


    /**
     * @param int $id
     *
     * @return [type]
     */
    public function abandon(int $id)
    {
        $candidat = Candidat::findOrFail($id);
        if($candidat->classeEnCours == 'L3' || $candidat->classeEnCours == 'L2' || $candidat->classeEnCours == 'L1'){
            $candidat->update(['status' => 'Abandon', 'abandon' => 1,]);
            Niv::where('annee',date('Y'))->where('candidat_id',$id)->update(['status' => 'Abandon']);
        } elseif($candidat->classeEnCours == 'M1' || $candidat->classeEnCours == 'M2'){
            $candidat->update(['status' => 'Licence/Abandon', 'abandon' => 1,]);
            Niv::where('annee',date('Y'))->where('candidat_id',$id)->update(['status' => 'Licence/Abandon']);
        }
        return response()->json(['success' => 1], 200);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return [type]
     */
    public function redouble(Request $request, int $id)
    {
        $candidat = Candidat::findOrFail($id);
        $groupe = $request->query('groupe');
        if($candidat->classe == 'L1') {
            $l1 = L1Model::where('candidat_id',$id)->orderByDesc('annee')->first();
            L1Model::create([
                'annee' => $l1->annee + 1,
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classe == 'L2'){
            $l2 = L2Model::where('candidat_id',$id)->orderByDesc('annee')->first();
            L2Model::create([
                'annee' => $l2->annee + 1,
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classe == 'L3'){
            $l3 = L3Model::where('candidat_id',$id)->orderByDesc('annee')->first();
            L3Model::create([
                'annee' => $l3->annee + 1,
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }elseif($candidat->classe == 'M1'){
            $m1 = M1Model::where('candidat_id',$id)->orderByDesc('annee')->first();
            M1Model::create([
                'annee' => $m1->annee + 1,
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);

        }else {
            $m2 = M2Model::where('candidat_id',$id)->orderByDesc('annee')->first();
            M2Model::create([
                'annee' => $m2->annee + 1,
                'candidat_id' => $candidat->id,
                'groupe' => $groupe,
            ]);
            return response()->json(['success' => 1],200);
        }


    }
}
