<?php

namespace App\Models;

use App\Models\Quartier;
use App\Models\AgentTerrain;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'libel',
        'nbrinscrit',
        'objectif',
        'seuil',
        'commune_id',
    ];
//DEPARTEMENT
    protected $searchableFields = ['*'];

    public function commune()//region
    {
        return $this->belongsTo(Commune::class);
    }

    public function quartiers()//communes
    {
        return $this->hasMany(RCommune::class);
    }

    public function agentDeSections()
    {
        return $this->hasMany(AgentDeSection::class);
    }

    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class);
    }

    public function scopeUserlimit($query)
    {
        $user = Auth::user();
        if($user->hasPermissionTo("can-open-section-only")){
            $name = $user->name;
            $prenom = $user->prenom;
            $agent_SectionId = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
            ])->with("section")->first();
            
            if($agent_SectionId) {
                return $query->where('id', '=', $agent_SectionId->section->id);
            }else return $query->where('id', -1);
        }
        
        if($user->hasPermissionTo("can-open-lvote-only")){
            $name = $user->name;
            $prenom = $user->prenom;
            $agentsuiviIds = OperateurSuivi::where([
                ["nom","like", $name],
                ["prenoms","like", $prenom],
            ])->first()->lieuVotes->pluck('id');
            
            if($agentsuiviIds) {
                return $query->whereHas('quartiers.lieuvotes', function($query) use($agentsuiviIds) {
                    $query->whereIn('id', $agentsuiviIds);
                });
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
