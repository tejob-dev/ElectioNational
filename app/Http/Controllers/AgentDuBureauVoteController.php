<?php

namespace App\Http\Controllers;

use App\Models\BureauVote;
use Illuminate\Http\Request;
use App\Models\AgentDuBureauVote;
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
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'app.agent_du_bureau_votes.index',
            compact('agentDuBureauVotes', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', AgentDuBureauVote::class);

        $bureauVotes = BureauVote::pluck('libel', 'id');

        return view('app.agent_du_bureau_votes.create', compact('bureauVotes'));
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

        return redirect()
            ->route('agent-du-bureau-votes.edit', $agentDuBureauVote)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDuBureauVote $agentDuBureauVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentDuBureauVote $agentDuBureauVote)
    {
        $this->authorize('view', $agentDuBureauVote);

        return view(
            'app.agent_du_bureau_votes.show',
            compact('agentDuBureauVote')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDuBureauVote $agentDuBureauVote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AgentDuBureauVote $agentDuBureauVote)
    {
        $this->authorize('update', $agentDuBureauVote);

        $bureauVotes = BureauVote::pluck('libel', 'id');

        return view(
            'app.agent_du_bureau_votes.edit',
            compact('agentDuBureauVote', 'bureauVotes')
        );
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

        return redirect()
            ->route('agent-du-bureau-votes.edit', $agentDuBureauVote)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('agent-du-bureau-votes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
