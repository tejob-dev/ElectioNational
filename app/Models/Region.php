<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'libel',
        'nbrinscrit',
        'objectif',
        'seuil',
        'district_id',
    ];

    protected $searchableFields = ['*'];

    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }
}
