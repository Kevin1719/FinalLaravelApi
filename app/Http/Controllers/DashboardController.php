<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Niv;
use App\Models\Preparatoire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $year;

    public function index()
    {
        $data = [];
        $anneeExist = [];
        $count = 0;
        $candidats = Candidat::all();
        $nivs = Niv::all();
        $preparatoires = Preparatoire::all();
        foreach($candidats as $candidat){
            if(!in_array($candidat->anneeCandidature,$anneeExist)){
                $anneeExist[] = $candidat->anneeCandidature;
            }
        }
        foreach($nivs as $niv){
            if(!in_array($niv->annee,$anneeExist)){
                $anneeExist[] = $niv->annee;
            }
        }
        foreach($preparatoires as $preparatoire){
            if(!in_array($preparatoire->annee, $anneeExist)){
                $anneeExist[] = $preparatoire->annee;
            }
        }
        arsort($anneeExist,SORT_NUMERIC);
        foreach($anneeExist as $year){
            $this->year = $year;
            $count = 0;
            foreach($preparatoires as $prepa){
                if($prepa->annee == $year){
                    foreach($candidats as $cand){
                        if(strtolower($cand->nom) == strtolower($prepa->nom) && strtolower($cand->prenom) == strtolower($prepa->prenom) && $prepa->annee == $cand->anneeCandidature){
                            $count++;
                        }
                    }
                }
            }
            $data [] = [

                    'year' => $year,
                    'nbrL1EnCour' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nbrL2EnCour' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nbrL3EnCour' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nbrM1EnCour' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nbrM2EnCour' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreCourPrepT' => Preparatoire::where('annee',$year)->count(),
                    'nombreCourPrepF' => Preparatoire::where('annee', $year)->where('genre', 'F')->count(),
                    'nombreCourPrepG' => Preparatoire::where('annee', $year)->where('genre', 'G')->count(),
                    'nombreCourPrepL1' => Preparatoire::where('annee', $year)->where('niveau', 'L1')->count(),
                    'nombreCourPrepL1G' => Preparatoire::where('annee', $year)->where('niveau', 'L1')->where('genre', 'G')->count(),
                    'nombreCourPrepL1F' => Preparatoire::where('annee', $year)->where('niveau', 'L1')->where('genre', 'F')->count(),
                    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCourPrepL2' => Preparatoire::where('annee', $year)->where('niveau', 'L2')->count(),
                    'nombreCourPrepL2G' => Preparatoire::where('annee', $year)->where('niveau', 'L2')->where('genre', 'G')->count(),
                    'nombreCourPrepL2F' => Preparatoire::where('annee', $year)->where('niveau', 'L2')->where('genre', 'F')->count(),
                    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCourPrepL3' => Preparatoire::where('annee', $year)->where('niveau', 'L3')->count(),
                    'nombreCourPrepL3G' => Preparatoire::where('annee', $year)->where('niveau', 'L3')->where('genre', 'G')->count(),
                    'nombreCourPrepL3F' => Preparatoire::where('annee', $year)->where('niveau', 'L3')->where('genre', 'F')->count(),
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCourPrepM1' => Preparatoire::where('annee', $year)->where('niveau', 'M1')->count(),
                    'nombreCourPrepM1G' => Preparatoire::where('annee', $year)->where('niveau', 'M1')->where('genre', 'G')->count(),
                    'nombreCourPrepM1F' => Preparatoire::where('annee', $year)->where('niveau', 'M1')->where('genre', 'F')->count(),
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCourPrepM2' => Preparatoire::where('annee', $year)->where('niveau', 'M2')->count(),
                    'nombreCourPrepM2G' => Preparatoire::where('annee', $year)->where('niveau', 'M2')->where('genre', 'G')->count(),
                    'nombreCourPrepM2F' => Preparatoire::where('annee', $year)->where('niveau', 'M2')->where('genre', 'F')->count(),
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'PrepaEtCandidat' => $count,
                    'nombreInscritT' => Niv::where('annee',$year)->count(),

                    'nombreInscritL1' => Niv::where('annee',$year)->where('classe', 'L1')->count(),

                    'nombreInscritL1Garcon' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL1Femme' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritL2' => Niv::where('annee',$year)->where('classe', 'L2')->count(),

                    'nombreInscritL2Garcon' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL2Femme' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritL3' => Niv::where('annee',$year)->where('classe', 'L3')->count(),

                    'nombreInscritL3Garcon' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL3Femme' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    'nombreInscritM1' => Niv::where('annee',$year)->where('classe', 'M1')->count(),

                    'nombreInscritM1Garcon' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritM1Femme' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritM2' => Niv::where('annee',$year)->where('classe', 'M2')->count(),

                    'nombreInscritM2Garcon' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritM2Femme' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonT' => Niv::where('annee',$year)->where('status','Abandon')->count(),

                    'nombreAbondonTGarcon' => Niv::where('annee',$year)->where('status','Abandon')->
                                                                where(function ($query){
                                                                    $query->select('genre')
                                                                        ->from('candidats')
                                                                        ->whereColumn('candidats.id', 'nivs.candidat_id');
                                                                }, 'G')
                                                                ->count(),
                    'nombreAbondonTFemme' => Niv::where('annee',$year)->where('status','Abandon')
                                                                    ->where(function ($query){
                                                                        $query->select('genre')
                                                                            ->from('candidats')
                                                                            ->whereColumn('candidats.id', 'nivs.candidat_id');
                                                                        }, 'F')
                                                                    ->count(),

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonL1' => Niv::where('annee', $year)->where('classe','L1')->where('status','Abandon')->count(),

                    'nombreAbondonGarconL1' =>Niv::where('annee', $year)->where('classe','L1')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL1' => Niv::where('annee', $year)->where('classe','L1')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                     'nombreAbondonL2' => Niv::where('annee', $year)->where('classe','L2')->where('status','Abandon')->count(),

                    'nombreAbondonGarconL2' =>Niv::where('annee', $year)->where('classe','L2')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL2' => Niv::where('annee', $year)->where('classe','L2')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonL3' => Niv::where('annee', $year)->where('classe','L3')->where('status','Abandon')->count(),

                    'nombreAbondonGarconL3' =>Niv::where('annee', $year)->where('classe','L3')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL3' => Niv::where('annee', $year)->where('classe','L3')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonM1' => Niv::where('annee', $year)->where('classe','M1')->where('status','Abandon')->count(),

                    'nombreAbondonGarconM1' =>Niv::where('annee', $year)->where('classe','M1')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleM1' => Niv::where('annee', $year)->where('classe','M1')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonM2' => Niv::where('annee', $year)->where('classe','M2')->where('status','Abandon')->count(),

                    'nombreAbondonGarconM2' =>Niv::where('annee', $year)->where('classe','M2')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleM2' => Niv::where('annee', $year)->where('classe','M2')->where('status','Abandon')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatCompletT' => Candidat::where('anneeCandidature', $year)->count(),
                    'nombreCandidatCompletL1' =>Candidat::where('anneeCandidature', $year)->where('postule','L1')->count(),
                    'nombreCandidatCompletL1G' =>Candidat::where('anneeCandidature', $year)->where('postule','L1')->where('genre','G')->count(),
                    'nombreCandidatCompletL1F' =>Candidat::where('anneeCandidature', $year)->where('postule','L1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatCompletL2' =>Candidat::where('anneeCandidature', $year)->where('postule','L2')->count(),
                    'nombreCandidatCompletL2G' =>Candidat::where('anneeCandidature', $year)->where('postule','L2')->where('genre','G')->count(),
                    'nombreCandidatCompletL2F' =>Candidat::where('anneeCandidature', $year)->where('postule','L2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatCompletL3' =>Candidat::where('anneeCandidature', $year)->where('postule','L3')->count(),
                    'nombreCandidatCompletL3G' =>Candidat::where('anneeCandidature', $year)->where('postule','L3')->where('genre','G')->count(),
                    'nombreCandidatCompletL3F' =>Candidat::where('anneeCandidature', $year)->where('postule','L3')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatCompletM1' =>Candidat::where('anneeCandidature', $year)->where('postule','M1')->count(),
                    'nombreCandidatCompletM1G' =>Candidat::where('anneeCandidature', $year)->where('postule','M1')->where('genre','G')->count(),
                    'nombreCandidatCompletM1F' =>Candidat::where('anneeCandidature', $year)->where('postule','M1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatCompletM2' =>Candidat::where('anneeCandidature', $year)->where('postule','M2')->count(),
                    'nombreCandidatCompletM2G' =>Candidat::where('anneeCandidature', $year)->where('postule','M2')->where('genre','G')->count(),
                    'nombreCandidatCompletM2F' =>Candidat::where('anneeCandidature', $year)->where('postule','M2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatValideT' => Candidat::where('anneeCandidature',$year)->where('entretien',1)->count(),
                    'nombreCandidatValideL1'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L1')->count(),
                    'nombreCandidatValideL1G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L1')->where('genre','G')->count(),
                    'nombreCandidatValideL1F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatValideL2'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L2')->count(),
                    'nombreCandidatValideL2G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L2')->where('genre','G')->count(),
                    'nombreCandidatValideL2F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatValideL3'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L3')->count(),
                    'nombreCandidatValideL3G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L3')->where('genre','G')->count(),
                    'nombreCandidatValideL3F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','L3')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatValideM1'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M1')->count(),
                    'nombreCandidatValideM1G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M1')->where('genre','G')->count(),
                    'nombreCandidatValideM1F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatValideM2'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M2')->count(),
                    'nombreCandidatValideM2G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M2')->where('genre','G')->count(),
                    'nombreCandidatValideM2F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 1)->where('postule','M2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatInValideT' => Candidat::where('anneeCandidature',$year)->where('entretien',0)->count(),
                    'nombreCandidatInValideL1'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L1')->count(),
                    'nombreCandidatInValideL1G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L1')->where('genre','G')->count(),
                    'nombreCandidatInValideL1F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatInValideL2'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L2')->count(),
                    'nombreCandidatInValideL2G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L2')->where('genre','G')->count(),
                    'nombreCandidatInValideL2F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatInValideL3'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L3')->count(),
                    'nombreCandidatInValideL3G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L3')->where('genre','G')->count(),
                    'nombreCandidatInValideL3F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','L3')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatInValideM1'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M1')->count(),
                    'nombreCandidatInValideM1G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M1')->where('genre','G')->count(),
                    'nombreCandidatInValideM1F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M1')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreCandidatInValideM2'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M2')->count(),
                    'nombreCandidatInValideM2G'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M2')->where('genre','G')->count(),
                    'nombreCandidatInValideM2F'=> Candidat::where('anneeCandidature', $year)->where('entretien', 0)->where('postule','M2')->where('genre','F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ];
        }

        return $data;
    }
}
