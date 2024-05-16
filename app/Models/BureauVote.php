<?php

namespace App\Models;

use App\Models\AgentDeSection;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BureauVote extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['libel', 'inscrit', 'objectif', 'seuil', 'lieu_vote_id', 'votant_suivi', 'votant_resul', 'bult_nul', 'bult_blan', 'candidat_note'];

    protected $searchableFields = ['*'];

    protected $table = 'bureau_votes';

    public function lieuVote()
    {
        return $this->belongsTo(LieuVote::class);
    }

    public function agentDuBureauVotes()
    {
        return $this->hasMany(AgentDuBureauVote::class);
    }

    public function procesVerbals()
    {
        return $this->hasMany(ProcesVerbal::class);
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
                return $query->with("lieuvote.quartier.section")->whereHas('lieuvote.quartier.section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("lieuvote.quartier.section")->whereHas('lieuvote.quartier.section', function($q) use($agent_SectionId) {
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
                return $query->whereHas('lieuvote', function($query) use($agentsuiviIds){
                    $query->whereIn('id', $agentsuiviIds);
                });
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
