<?php

namespace App\Imports;

use App\Models\Candidat;
use App\Models\Niv;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InscriptionsImport implements ToArray, WithHeadingRow
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

    public function takeEtatEtudiant($admis)
    {
        if(strtolower($admis) == 'oui'){
            return 1;
        } elseif(strtolower($admis) == 'non'){
            return 0;
        }
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
            if(!is_null($row['noms_de_letudiant'])){
                $anneeCandidature = $this->takeCandidature($row['date_dinscription_de_lannee_scolaire']);
                $nom_prenom = $this->takeNomEtPrenom($row['noms_de_letudiant']);
                $admis = $this->takeEtatEtudiant($row['admis']);
                $etudiant = Candidat::where('nom',$nom_prenom[0])->where('prenom',$nom_prenom[1])->first();
                if(is_null($etudiant)){
                    $cand = Candidat::create([
                        'nom' => $nom_prenom[0],
                        'prenom' => $nom_prenom[1],
                        'genre' => $row['genre'],
                        'postule' => $row['niveau'],
                        'entretien' => $admis,
                        'anneeCandidature' =>$anneeCandidature,
                        'serie' => $row['serie_du_bacc'],
                        'nationalite' => $row['nationalite'],
                        'contact' => $row['contact'],
                        'adresse' => $row['adresse'],
                        'dateDeNaissance' => $row['date_de_naissance'],
                        'nomPere' => $row['nom_pere'],
                        'nomMere' => $row['nom_mere'],
                        'nomTuteur' =>$row['nom_tuteur'],
                        'professionPere' => $row['profession_pere'],
                        'professionMere' => $row['profession_mere'],
                        'professionTuteur' => $row['profession_tuteur'],
                    ]);
                } else {
                    $etudiant->update([
                        'nom' => $nom_prenom[0],
                        'prenom' => $nom_prenom[1],
                        'genre' => $row['genre'],
                        'postule' => $row['niveau'],
                        'entretien' => $admis,
                        'anneeCandidature' =>$anneeCandidature,
                        'serie' => $row['serie_du_bacc'],
                        'nationalite' => $row['nationalite'],
                        'contact' => $row['contact'],
                        'adresse' => $row['adresse'],
                        'dateDeNaissance' => $row['date_de_naissance'],
                        'nomPere' => $row['nom_pere'],
                        'nomMere' => $row['nom_mere'],
                        'nomTuteur' =>$row['nom_tuteur'],
                        'professionPere' => $row['profession_pere'],
                        'professionMere' => $row['profession_mere'],
                        'professionTuteur' => $row['profession_tuteur'],
                    ]);
                }

            }
        }
    }
}
