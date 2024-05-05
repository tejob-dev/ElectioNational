<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AgentDuBureauVote;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentDuBureauVoteResource;
use App\Http\Resources\AgentDuBureauVoteCollection;
use App\Http\Requests\AgentDuBureauVoteStoreRequest;
use App\Http\Requests\AgentDuBureauVoteUpdateRequest;

class AgentDuBureauVoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AgentDuBureauVote::class);

        $search = $request->get('search', '');

        $agentDuBureauVotes = AgentDuBureauVote::search($search)
            ->latest()
            ->paginate();

        return new AgentDuBureauVoteCollection($agentDuBureauVotes);
    }

    /**
     * @param \App\Http\Requests\AgentDuBureauVoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentDuBureauVoteStoreRequest $request)
    {
        $this->authorize('create', AgentDuBureauVote::class);

        $validated = $request->validated();

        $agentDuBureauVote = AgentDuBureauVote::create($validated);

        return new AgentDuBureauVoteResource($agentDuBureauVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDuBureauVote $agentDuBureauVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentDuBureauVote $agentDuBureauVote)
    {
        $this->authorize('view', $agentDuBureauVote);

        return new AgentDuBureauVoteResource($agentDuBureauVote);
    }

    /**
     * @param \App\Http\Requests\AgentDuBureauVoteUpdateRequest $request
     * @param \App\Models\AgentDuBureauVote $agentDuBureauVote
     * @return \Illuminate\Http\Response
     */
    public function update(
        AgentDuBureauVoteUpdateRequest $request,
        AgentDuBureauVote $agentDuBureauVote
    ) {
        $this->authorize('update', $agentDuBureauVote);

        $validated = $request->validated();

        $agentDuBureauVote->update($validated);

        return new AgentDuBureauVoteResource($agentDuBureauVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDuBureauVote $agentDuBureauVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        AgentDuBureauVote $agentDuBureauVote
    ) {
        $this->authorize('delete', $agentDuBureauVote);

        $agentDuBureauVote->delete();

        return response()->noContent();
    }
}
