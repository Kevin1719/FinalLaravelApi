<?php

namespace App\Imports;

use App\Models\Candidat;
use App\Models\Niv;
use App\Models\Preparatoire;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreparatoiresImport implements ToArray, WithHeadingRow
{

    /**
     * @param mixed $valeur
     *
     * @return array [$classe,$groupe]
     */
    public function takeNomEtPrenom($valeur)
    {
        $prenom = "";
        $nom_prenom = [];
        $expl_firstname = [];
        $nom_prenom = explode(" ",$valeur);
        $nom = $nom_prenom[0];

        foreach($nom_prenom as $k => $expl_fullname){
            if($k != 0 ){
                $expl_firstname[] = $expl_fullname;
            };
        }
        if(!is_null($expl_firstname)){
            $prenom = implode("",$expl_firstname);
        }

        return [$nom,$prenom];
    }

    public function takeCandidature($date_dinscription_de_lannee_scolaire)
    {
        $parts = explode(' ',$date_dinscription_de_lannee_scolaire);
        return $parts[1];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $data)
    {

        foreach($data as  $row){
            if(!is_null($row['noms_de_letudiant'])) {
                $nom_prenom = $this->takeNomEtPrenom($row['noms_de_letudiant']);
                $etudiant = Preparatoire::where('nom',$nom_prenom[0])->where('prenom',$nom_prenom[1])->first();
                if(is_null($etudiant)){
                    $cand = Preparatoire::create([
                        'nom' => $nom_prenom[0],
                        'prenom' => $nom_prenom[1],
                        'email' => $row['email'],
                        'genre' => $row['genre'],
                        'niveau' => $row['niveau'],
                        'annee' =>$row['annee'],
                        'serie' => $row['serie'],
                        'contact' => $row['contact'],
                        'adresse' => $row['adresse'],
                        'validation' => 1,
                    ]);
                } else {
                    $etudiant->update([
                        'nom' => $nom_prenom[0],
                        'prenom' => $nom_prenom[1],
                        'email' => $row['email'],
                        'genre' => $row['genre'],
                        'niveau' => $row['niveau'],
                        'annee' =>$row['annee'],
                        'serie' => $row['serie'],
                        'contact' => $row['contact'],
                        'adresse' => $row['adresse'],
                        'validation' => 1,
                    ]);
                }

            }
        }
    }
}
