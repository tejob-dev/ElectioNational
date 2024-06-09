<?php

namespace App\Models;

use App\Models\Parrain;
use App\Models\Rabatteur;
use App\Models\AgentDeSection;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LieuVote extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'code',
        'libel',
        'nbrinscrit',
        'objectif',
        'seuil',
        'quartier_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'lieu_votes';

    public function quartier()//section
    {
        return $this->belongsTo(Quartier::class);
    }

    public function bureauVotes()
    {
        return $this->hasMany(BureauVote::class);
    }

    public function supLieuDeVotes()
    {
        return $this->hasMany(SupLieuDeVote::class);
    }

    public function agentTerrains()
    {
        return $this->hasMany(AgentTerrain::class);
    }
    
    public function parrains()
    {
        return $this->hasMany(Parrain::class, "code_lv", "libel");
    }

    public function electorats()
    {
        return $this->hasMany(ElectorParrain::class, "nom_lv", "libel");
    }

    public function communes()
    {
        return $this->belongsToMany(Commune::class);
    }

    public function rabatteurs()
    {
        return $this->belongsToMany(Rabatteur::class);
    }

    public function operateurSuivis()
    {
        return $this->belongsToMany(OperateurSuivi::class);
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
                return $query->with("quartier.section")->whereHas('quartier.section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("quartier.section")->whereHas('quartier.section', function($q) use($agent_SectionId) {
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
                return $query->whereIn('id', $agentsuiviIds);
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
