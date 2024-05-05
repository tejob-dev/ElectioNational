<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperateurSuivi extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nom', 'prenoms', 'telephone'];

    protected $searchableFields = ['*'];

    protected $table = 'operateur_suivis';

    public function lieuVotes()
    {
        return $this->belongsToMany(LieuVote::class);
    }
}
