<?php

namespace App\Models;

use App\Models\Parrain;
use App\Models\Section;
use App\Models\LieuVote;
use App\Models\SousSection;
use App\Models\AgentMessage;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentTerrain extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nom',
        'prenom',
        'code',
        'telephone',
        'profil',
        'district_id',
        'region_id',
        'departement_id',
        'commune_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'agent_terrains';

    // public function lieuVote()
    // {
    //     return $this->belongsTo(LieuVote::class);
    // }
    
    // public function section()
    // {
    //     return $this->belongsTo(Quartier::class);
    // }
    // public function sousSection()
    // {
    //     return $this->belongsTo(SousSection::class);
    // }
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
    

    public function parrains()
    {
        return $this->hasMany(Parrain::class, "telephone_par", 'telephone');
    }

    
    public function messageEnvoyes()
    {
        return $this->hasMany(AgentMessage::class, "from", 'id');
    }
    
    public function messageRecus()
    {
        return $this->hasMany(AgentMessage::class, "to", 'id');
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
                return $query->with("section")->whereHas('section', function($q) use($agent_SectionId) {
                    $q->where('id', "=", $agent_SectionId->section->id);
                });
            }else{
                return $query->with("id")->whereHas('section', function($q) use($agent_SectionId) {
                    $q->where('id', -1);
                });
            }
        }

        return $query;
    }
}
