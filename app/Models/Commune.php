<?php

namespace App\Models;

use App\Models\User;
use App\Models\Section;
use App\Models\LieuVote;
use App\Models\Departement;
use App\Models\AgentDeSection;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'libel',
        'code',
        'nbrinscrit',
        'objectif',
        'seuil',
        'rgph_population',
        'departement_id',
    ];

    protected $searchableFields = ['*'];
    //REGIONS
    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class);
    }

    public function parrains()
    {
        return $this->hasMany(Parrain::class);
    }

    public function lieuVotes()
    {
        return $this->hasMany(LieuVote::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function scopeUserlimit($query)
    {
        $user = Auth::user();
        if($user->hasPermissionTo("can-open-section-only")){
            $name = $user->name;
            $prenom = $user->prenom;
            $commune = $user->commune;

            if($commune != null){
                return $query->where('id', '=', $commune->id);
            }

            $agent_SectionId = AgentDeSection::where([
                ["nom","like", $name],
                ["prenom","like", $prenom],
                ])->with("section")->first();

            if($agent_SectionId) return $query->where('id', '=', $agent_SectionId->section->section->commune->id);
            else  return $query->where('id', -1);

        }

        if($user->hasPermissionTo("can-open-lvote-only")){
            $name = $user->name;
            $prenom = $user->prenom;
            $agentsuiviIds = OperateurSuivi::where([
                ["nom","like", $name],
                ["prenoms","like", $prenom],
            ])->first()->lieuVotes->pluck('id');
            
            if($agentsuiviIds) {
                return $query->whereHas('sections.quartiers.lieuvotes', function($query) use($agentsuiviIds) {
                    $query->whereIn('id', $agentsuiviIds);
                });
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
