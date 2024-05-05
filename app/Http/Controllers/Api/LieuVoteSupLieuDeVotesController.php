<?php

namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupLieuDeVoteResource;
use App\Http\Resources\SupLieuDeVoteCollection;

class LieuVoteSupLieuDeVotesController extends Controller
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

        $supLieuDeVotes = $lieuVote
            ->supLieuDeVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupLieuDeVoteCollection($supLieuDeVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('create', SupLieuDeVote::class);

        $validated = $request->validate([
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'telephone' => ['required', 'max:255', 'string'],
        ]);

        $supLieuDeVote = $lieuVote->supLieuDeVotes()->create($validated);

        return new SupLieuDeVoteResource($supLieuDeVote);
    }
}
