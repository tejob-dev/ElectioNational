<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentDuBureauVote extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nom', 'prenom', 'telphone', 'bureau_vote_id'];

    protected $searchableFields = ['*'];

    protected $table = 'agent_du_bureau_votes';

    public function bureauVote()
    {
        return $this->belongsTo(BureauVote::class);
    }

    public function scopeUserlimit($query){
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

        return $query;
    }
}
