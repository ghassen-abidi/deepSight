<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'adresse',
        'tel',
        'email',
        'logo',
        'status',
        'annee_scolaire',
    ];
}
