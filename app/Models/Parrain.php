<?php

namespace App\Models;

use App\Models\AgentTerrain;
use App\Models\AgentDeSection;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parrain extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nom_pren_par',
        'telephone_par',
        'recenser',
        'nom',
        'prenom',
        'cart_milit',
        'is_milit',
        'list_elect',
        'cart_elect',
        'cni_dispo',
        'extrait',
        'telephone',
        'date_naiss',
        'code_lv',
        'residence',
        'profession',
        'observation',
        'status',
        'a_vote',
        'created_at',
        'updated_at',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date_naiss' => 'date',
    ];
    
    public function agentTerrain()
    {
        return $this->belongsTo(AgentTerrain::class, "telephone_par", "telephone");
    }
    
    public function lieuVote()
    {
        return $this->belongsTo(LieuVote::class, "code_lv", "code");
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
                return $query->with("agentterrain.section")->whereHas('agentterrain.section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else return $query->with("agentterrain.section")->whereHas('agentterrain.section', function($q) use($agent_SectionId) {
                $q->where('id', -1);
            });
        }

        return $query;
    }
}
