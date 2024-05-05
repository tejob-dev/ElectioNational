<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AgentDeSection;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentDeSectionResource;
use App\Http\Resources\AgentDeSectionCollection;
use App\Http\Requests\AgentDeSectionStoreRequest;
use App\Http\Requests\AgentDeSectionUpdateRequest;

class AgentDeSectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AgentDeSection::class);

        $search = $request->get('search', '');

        $agentDeSections = AgentDeSection::search($search)
            ->latest()
            ->paginate();

        return new AgentDeSectionCollection($agentDeSections);
    }

    /**
     * @param \App\Http\Requests\AgentDeSectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentDeSectionStoreRequest $request)
    {
        $this->authorize('create', AgentDeSection::class);

        $validated = $request->validated();

        $agentDeSection = AgentDeSection::create($validated);

        return new AgentDeSectionResource($agentDeSection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentDeSection $agentDeSection)
    {
        $this->authorize('view', $agentDeSection);

        return new AgentDeSectionResource($agentDeSection);
    }

    /**
     * @param \App\Http\Requests\AgentDeSectionUpdateRequest $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function update(
        AgentDeSectionUpdateRequest $request,
        AgentDeSection $agentDeSection
    ) {
        $this->authorize('update', $agentDeSection);

        $validated = $request->validated();

        $agentDeSection->update($validated);

        return new AgentDeSectionResource($agentDeSection);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AgentDeSection $agentDeSection)
    {
        $this->authorize('delete', $agentDeSection);

        $agentDeSection->delete();

        return response()->noContent();
    }
}
