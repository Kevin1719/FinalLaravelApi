<?php

namespace App\Imports;

use App\Models\Candidat;
use App\Models\Niv;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CandidatsImport implements ToArray, WithHeadingRow
{
    protected $class_group;
       /**
     * @param mixed $valeur
     *
     * @return aray [$nom ,$prenom]
     */
    public function takeClasseAndGroupe($valeur)
    {
        $split_group = [];
        $dd = (str_split($valeur,2));
        $classe = $dd[0];
        foreach($dd as $k => $split){
            if($k != 0){
                $split_group[] = $split;
            }
        }
        $groupe = implode("",$split_group);
        return [$classe, $groupe];
    }


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

    public function takeEtatEtudiant($status, $abandon, $diplome)
    {
        if(strtolower($status) == 'en cours'){
            if(strtolower($diplome) == 'licence'){
                return ['Licence/En Cours', 0];
            } elseif(strtolower($diplome) == 'master') {
                return ['Master', 0];
            } else {
                return ['En Cours', 0];
            }
        } elseif(strtolower($abandon) == 'oui'){
            return ['Abandon', 1];
        }
    }
    public function takeCandidature($ancienMatricule)
    {
        $parts = explode('-',$ancienMatricule);
        return $parts[0];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $data)
    {

        foreach($data as $k => $row){
            if($k === 0){
                $this->class_group = $this->takeClasseAndGroupe($row[0]);

            } else {
                if(!is_null($row['noms_de_letudiant'])){
                    $anneeCandidature = $this->takeCandidature($row[1]);
                    $nom_prenom = $this->takeNomEtPrenom($row['noms_de_letudiant']);
                    $etats = $this->takeEtatEtudiant($row['statut'], $row['abandon'], $row['a_diplomer']);
                    $etudiant = Candidat::where('nom',$nom_prenom[0])->where('prenom',$nom_prenom[1])->first();
                    if(is_null($etudiant)){
                        $cand = Candidat::create([
                            'nom' => $nom_prenom[0],
                            'prenom' => $nom_prenom[1],
                            'email' => $row['email'],
                            'matricule' => $row['nouveaux_matricules'],
                            'genre' => $row['genre'],
                            'entretien' => 1,
                            'status' => $etats[0],
                            'abandon' => $etats[1],
                        ]);
                        Niv::create([
                            'annee' => $row['annee'],
                            'groupe' => $this->class_group[1],
                            'classe' => $this->class_group[0],
                            'status' => $etats[0],
                            'candidat_id' => $cand->id,
                        ]);
                    } else {
                        $etudiant->update([
                            'nom' => $nom_prenom[0],
                            'prenom' => $nom_prenom[1],
                            'email' => $row['email'],
                            'matricule' => $row['nouveaux_matricules'],
                            'genre' => $row['genre'],
                            'entretien' => 1,
                            'status' => $etats[0],
                            'abandon' => $etats[1],

                        ]);
                        Niv::create([
                            'annee' => $row['annee'],
                            'groupe' => $this->class_group[1],
                            'classe' => $this->class_group[0],
                            'status' => $etats[0],
                            'candidat_id' => $etudiant->id,
                        ]);
                    }
                }
            }
        }
    }
}
