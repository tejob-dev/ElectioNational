<?php

namespace App\Models;

use App\Models\CorParrain;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rabatteur extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nom', 'prenoms', 'telephone'];

    protected $searchableFields = ['*'];

    public function lieuVotes()
    {
        return $this->belongsToMany(LieuVote::class);
    }

    public function parrains()
    {
        return $this->hasMany(CorParrain::class, "agent_res_phone", 'telephone');
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

        return $query;
    }
}
