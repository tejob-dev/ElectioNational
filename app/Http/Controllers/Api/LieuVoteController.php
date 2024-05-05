<?php

namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LieuVoteResource;
use App\Http\Resources\LieuVoteCollection;
use App\Http\Requests\LieuVoteStoreRequest;
use App\Http\Requests\LieuVoteUpdateRequest;

class LieuVoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', LieuVote::class);

        $search = $request->get('search', '');

        $lieuVotes = LieuVote::search($search)
            ->latest()
            ->paginate();

        return new LieuVoteCollection($lieuVotes);
    }

    /**
     * @param \App\Http\Requests\LieuVoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LieuVoteStoreRequest $request)
    {
        $this->authorize('create', LieuVote::class);

        $validated = $request->validated();

        $lieuVote = LieuVote::create($validated);

        return new LieuVoteResource($lieuVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('view', $lieuVote);

        return new LieuVoteResource($lieuVote);
    }

    /**
     * @param \App\Http\Requests\LieuVoteUpdateRequest $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function update(LieuVoteUpdateRequest $request, LieuVote $lieuVote)
    {
        $this->authorize('update', $lieuVote);

        $validated = $request->validated();

        $lieuVote->update($validated);

        return new LieuVoteResource($lieuVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('delete', $lieuVote);

        $lieuVote->delete();

        return response()->noContent();
    }
}
