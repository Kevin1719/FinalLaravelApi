<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M2Model extends Model
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
