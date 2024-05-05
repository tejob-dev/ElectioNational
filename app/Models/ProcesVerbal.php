<?php

namespace App\Models;

use App\Models\BureauVote;
use App\Models\AgentDeSection;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcesVerbal extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['libel', 'photo', 'bureau_vote_id'];

    protected $searchableFields = ['*'];

    protected $table = 'proces_verbals';

    public function bureauVote()
    {
        return $this->belongsTo(BureauVote::class);
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
                return $query->with("bureauvote.lieuvote.quartier.section")->whereHas('bureauvote.lieuvote.quartier.section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("bureauvote.lieuvote.quartier.section")->whereHas('bureauvote.lieuvote.quartier.section', function($q) use($agent_SectionId) {
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
                $bvIds = BureauVote::whereIn('lieu_vote_id', $agentsuiviIds)->get();
                return $query->whereIn('bureau_vote_id', $bvIds->pluck('id'));
            }else return $query->where('id', -1);
        }

        return $query;
    }
}
