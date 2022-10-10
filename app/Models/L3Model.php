<?php

namespace App\Models;

use App\Models\Candidat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class L3Model extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
    public function getanneeUniversitaireAttribute()
    {
        $annee = $this->candidat->anneeCandidature + 1;

        return $this->candidat->anneeCandidature.'-'.$annee;
    }
}
