<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'date_naiss',
        'password',
        'commune_id',
        'departement_id',
        'photo',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_naiss' => 'date',
        'email_verified_at' => 'datetime',
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
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

            /* if($agent_SectionId){
                return $query->where(function($q) use($agent_SectionId){
                    
                    $q->name == 

                });
            }else  */
            return $query->where("id", "=", $user->id);
        }

        return $query;
    }
}
