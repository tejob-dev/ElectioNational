<?php

namespace App\Models;

use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quartier extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'libel',
        'nbrinscrit',
        'objectif',
        'seuil',
        'r_commune_id',
    ];
//SECTION
    protected $searchableFields = ['*'];

    public function section()//commune
    {
        return $this->belongsTo(RCommune::class, 'r_commune_id', 'id');
    }

    public function agentDeSections()
    {
        return $this->hasMany(AgentDeSection::class, 'section_id', 'id');
    }

    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class, 'section_id', 'id');
    }

    public function lieuVotes()
    {
        return $this->hasMany(LieuVote::class);
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
            
            if($agent_SectionId){
                return $query->with("section")->whereHas('section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("section")->whereHas('section', function($q) use($agent_SectionId) {
                    $q->where('id', -1);
                });
            }
        }

        if($user->hasPermissionTo("can-open-lvote-only")){
            $name = $user->name;
            $prenom = $user->prenom;
            $agentsuiviIds = OperateurSuivi::where([
                ["nom","like", $name],
                ["prenoms","like", $prenom],
            ])->first()->lieuVotes->pluck('id');
            
            if($agentsuiviIds) {
                return $query->whereHas('lieuvotes', function($query) use($agentsuiviIds) {
                    $query->whereIn('id', $agentsuiviIds);
                });
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
