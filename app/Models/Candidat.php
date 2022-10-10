<?php

namespace App\Models;

use DateTime;
use App\Models\Niv;
use App\Models\L1Model;
use App\Models\L2Model;
use App\Models\L3Model;
use App\Models\M1Model;
use App\Models\M2Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidat extends Model
{
    use HasFactory;
    protected $table = 'candidats';
    protected $guarded = [];

    public function niveaux()
    {
        return $this->hasMany(Niv::class);
    }

    public function getanneeUniversitaireAttribute()
    {
        $annee = $this->anneeCandidature + 1;

        return $this->anneeCandidature.'-'.$annee;
    }
    public function getageAttribute()
    {
        $date1 = new DateTime($this->dateDeNaissance);
        $date2 = new DateTime('now');

        $diff = $date1->diff($date2);

        return $diff->y;
    }
}
