<?php

namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentTerrainResource;
use App\Http\Resources\AgentTerrainCollection;

class LieuVoteAgentTerrainsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('view', $lieuVote);

        $search = $request->get('search', '');

        $agentTerrains = $lieuVote
            ->agentTerrains()
            ->search($search)
            ->latest()
            ->paginate();

        return new AgentTerrainCollection($agentTerrains);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('create', AgentTerrain::class);

        $validated = $request->validate([
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'code' => [
                'required',
                'unique:agent_terrains,code',
                'max:255',
                'string',
            ],
            'telephone' => [
                'required',
                'unique:agent_terrains,telephone',
                'max:255',
                'string',
            ],
        ]);

        $agentTerrain = $lieuVote->agentTerrains()->create($validated);

        return new AgentTerrainResource($agentTerrain);
    }
}
