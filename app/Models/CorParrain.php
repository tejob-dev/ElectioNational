<?php

namespace App\Models;

use App\Models\LieuVote;
use App\Models\AgentDeSection;
use App\Models\OperateurSuivi;
use App\Models\Scopes\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CorParrain extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'subid',
        'nom_prenoms',
        'phone',
        'carte_elect',
        'nom_lv',
        'agent_res_nompren',
        'agent_res_phone',
        'a_vote',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'cor_parrains';

    protected $casts = [
        'a_vote' => 'boolean',
    ];

    public function lieuVote()
    {
        return $this->belongsTo(LieuVote::class, "nom_lv", "libel");
    }

    public function scopeUserlimit($query)
    {
        $user = Auth::user();
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
