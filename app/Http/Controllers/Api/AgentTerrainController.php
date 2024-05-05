<?php

namespace App\Http\Controllers\Api;

use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentTerrainResource;
use App\Http\Resources\AgentTerrainCollection;
use App\Http\Requests\AgentTerrainStoreRequest;
use App\Http\Requests\AgentTerrainUpdateRequest;

class AgentTerrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AgentTerrain::class);

        $search = $request->get('search', '');

        $agentTerrains = AgentTerrain::search($search)
            ->latest()
            ->paginate();

        return new AgentTerrainCollection($agentTerrains);
    }

    /**
     * @param \App\Http\Requests\AgentTerrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentTerrainStoreRequest $request)
    {
        $this->authorize('create', AgentTerrain::class);

        $validated = $request->validated();

        $agentTerrain = AgentTerrain::create($validated);

        return new AgentTerrainResource($agentTerrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentTerrain $agentTerrain)
    {
        $this->authorize('view', $agentTerrain);

        return new AgentTerrainResource($agentTerrain);
    }

    /**
     * @param \App\Http\Requests\AgentTerrainUpdateRequest $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function update(
        AgentTerrainUpdateRequest $request,
        AgentTerrain $agentTerrain
    ) {
        $this->authorize('update', $agentTerrain);

        $validated = $request->validated();

        $agentTerrain->update($validated);

        return new AgentTerrainResource($agentTerrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AgentTerrain $agentTerrain)
    {
        $this->authorize('delete', $agentTerrain);

        $agentTerrain->delete();

        return response()->noContent();
    }
}
