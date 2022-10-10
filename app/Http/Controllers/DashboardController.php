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
                    'nbrL1EnCour' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreInscritL1Garcon' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL1Femme' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritL2' => Niv::where('annee',$year)->where('classe', 'L2')->count(),
                    'nbrL2EnCour' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreInscritL2Garcon' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL2Femme' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritL3' => Niv::where('annee',$year)->where('classe', 'L3')->count(),
                    'nbrL3EnCour' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreInscritL3Garcon' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritL3Femme' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    'nombreInscritM1' => Niv::where('annee',$year)->where('classe', 'M1')->count(),
                    'nbrM1EnCour' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreInscritM1Garcon' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritM1Femme' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreInscritM2' => Niv::where('annee',$year)->where('classe', 'M2')->count(),
                    'nbrM2EnCour' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },0)->count(),
                    'nombreInscritM2Garcon' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),
                    'nombreInscritM2Femme' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonT' => Niv::where('annee',$year)->where(function ($query){
                                                                    $query->select('abandon')
                                                                        ->from('candidats')
                                                                        ->whereColumn('candidats.id', 'nivs.candidat_id');
                                                                }, 1)
                                                                ->count(),

                    'nombreAbondonTGarcon' => Niv::where('annee',$year)->where(function ($query){
                                                                    $query->select('abandon')
                                                                        ->from('candidats')
                                                                        ->where('genre','G')
                                                                        ->whereColumn('candidats.id', 'nivs.candidat_id');
                                                                }, 1)
                                                                ->count(),
                    'nombreAbondonTFemme' => Niv::where('annee',$year)->where(function ($query){
                                                                    $query->select('abandon')
                                                                        ->from('candidats')
                                                                        ->where('genre','F')
                                                                        ->whereColumn('candidats.id', 'nivs.candidat_id');
                                                                }, 1)
                                                                ->count(),

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonL1' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->count(),

                    'nombreAbondonGarconL1' =>Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL1' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                     'nombreAbondonL2' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->count(),

                    'nombreAbondonGarconL2' =>Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL2' => Niv::where('annee', $year)->where('classe','L2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonL3' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->count(),

                    'nombreAbondonGarconL3' =>Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleL3' => Niv::where('annee', $year)->where('classe','L3')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonM1' => Niv::where('annee', $year)->where('classe','L1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->count(),

                    'nombreAbondonGarconM1' =>Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleM1' => Niv::where('annee', $year)->where('classe','M1')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    'nombreAbondonM2' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->count(),

                    'nombreAbondonGarconM2' =>Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'G')->count(),

                    'nombreAbondonFilleM2' => Niv::where('annee', $year)->where('classe','M2')->where(function ($query){
                        $query->select('abandon')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },1)->where(function ($query){
                        $query->select('genre')->from('candidats')->whereColumn('candidats.id','=','nivs.candidat_id');
                    },'F')->count(),
            ];
        }

        return $data;
    }
}
