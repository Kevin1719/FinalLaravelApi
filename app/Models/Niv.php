<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niv extends Model
{
    use HasFactory;
    protected $table = 'nivs';
    protected $guarded = [];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}
