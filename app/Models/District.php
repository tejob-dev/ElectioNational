<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['libel', 'nbrinscrit', 'objectif', 'seuil'];

    protected $searchableFields = ['*'];

    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class);
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
