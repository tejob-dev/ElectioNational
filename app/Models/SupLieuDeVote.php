<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupLieuDeVote extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nom', 'prenom', 'telephone', 'lieu_vote_id'];

    protected $searchableFields = ['*'];

    protected $table = 'sup_lieu_de_votes';

    public function lieuVote()
    {
        return $this->belongsTo(LieuVote::class);
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
                return $query->with("lieuVote.quartier.section")->whereHas('lieuVote.quartier.section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("lieuVote.quartier.section")->whereHas('lieuVote.quartier.section', function($q) use($agent_SectionId) {
                    $q->where('id', -1);
                });
            }
        }

        return $query;
    }
}
