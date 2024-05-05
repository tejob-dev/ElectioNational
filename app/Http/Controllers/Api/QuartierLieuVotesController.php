<?php

namespace App\Http\Controllers\Api;

use App\Models\Quartier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LieuVoteResource;
use App\Http\Resources\LieuVoteCollection;

class QuartierLieuVotesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quartier $quartier)
    {
        $this->authorize('view', $quartier);

        $search = $request->get('search', '');

        $lieuVotes = $quartier
            ->lieuVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new LieuVoteCollection($lieuVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quartier $quartier)
    {
        $this->authorize('create', LieuVote::class);

        $validated = $request->validate([
            'code' => [
                'required',
                'unique:lieu_votes,code',
                'max:255',
                'string',
            ],
            'libel' => ['required', 'max:255', 'string'],
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
        ]);

        $lieuVote = $quartier->lieuVotes()->create($validated);

        return new LieuVoteResource($lieuVote);
    }
}
