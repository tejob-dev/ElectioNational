<?php

namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BureauVoteResource;
use App\Http\Resources\BureauVoteCollection;

class LieuVoteBureauVotesController extends Controller
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

        $bureauVotes = $lieuVote
            ->bureauVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new BureauVoteCollection($bureauVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('create', BureauVote::class);

        $validated = $request->validate([
            'libel' => ['required', 'max:255', 'string'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
        ]);

        $bureauVote = $lieuVote->bureauVotes()->create($validated);

        return new BureauVoteResource($bureauVote);
    }
}
