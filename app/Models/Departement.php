<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'libel',
        'nbrinscrit',
        'objectif',
        'seuil',
        'region_id',
    ];

    protected $searchableFields = ['*'];

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    // public function communes()
    // {
    //     return $this->belongsToMany(Commune::class);
    // }
        public function agentTerrains()
        {
            return $this->hasMany(AgentTerrain::class);
        }

        public function region()
        {
            return $this->belongsTo(Region::class);
        }

        public function communes()
        {
            return $this->hasMany(Commune::class);
        }
}
