<?php

namespace App\Http\Controllers\Api;

use App\Models\BureauVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentDuBureauVoteResource;
use App\Http\Resources\AgentDuBureauVoteCollection;

class BureauVoteAgentDuBureauVotesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('view', $bureauVote);

        $search = $request->get('search', '');

        $agentDuBureauVotes = $bureauVote
            ->agentDuBureauVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new AgentDuBureauVoteCollection($agentDuBureauVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('create', AgentDuBureauVote::class);

        $validated = $request->validate([
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'telphone' => ['required', 'max:255', 'string'],
        ]);

        $agentDuBureauVote = $bureauVote
            ->agentDuBureauVotes()
            ->create($validated);

        return new AgentDuBureauVoteResource($agentDuBureauVote);
    }
}
