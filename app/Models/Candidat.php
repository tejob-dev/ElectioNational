<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidat extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nom',
        'prenom',
        'code',
        'photo',
        'couleur',
        'parti',
    ];

    protected $searchableFields = ['*'];
}
