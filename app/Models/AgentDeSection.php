<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentDeSection extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nom', 'prenom', 'telephone', 'section_id'];

    protected $searchableFields = ['*'];

    protected $table = 'agent_de_sections';

    public function section()
    {
        return $this->belongsTo(Quartier::class);
    }
}
