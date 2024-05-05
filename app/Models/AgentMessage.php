<?php

namespace App\Models;

use App\Models\AgentTerrain;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentMessage extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [''];
    
    protected $searchableFields = ['*'];

    protected $table = 'agent_messages';

    public function appartenantA(){
        return $this->belongsTo(AgentTerrain::class, 'from', 'id');
    }
    
    public function venantDe(){
        return $this->belongsTo(AgentTerrain::class, 'to', 'id');
    }
}
