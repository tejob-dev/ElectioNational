<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use App\Models\AgentTerrain;
use App\Models\AgentDeSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SousSection extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['libel', 'objectif'];

    protected $searchableFields = ['*'];

    protected $table = 'sous_sections';
    
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

        return $query;
    }
}
