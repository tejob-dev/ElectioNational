<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SupLieuDeVote;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupLieuDeVoteResource;
use App\Http\Resources\SupLieuDeVoteCollection;
use App\Http\Requests\SupLieuDeVoteStoreRequest;
use App\Http\Requests\SupLieuDeVoteUpdateRequest;

class SupLieuDeVoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SupLieuDeVote::class);

        $search = $request->get('search', '');

        $supLieuDeVotes = SupLieuDeVote::search($search)
            ->latest()
            ->paginate();

        return new SupLieuDeVoteCollection($supLieuDeVotes);
    }

    /**
     * @param \App\Http\Requests\SupLieuDeVoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupLieuDeVoteStoreRequest $request)
    {
        $this->authorize('create', SupLieuDeVote::class);

        $validated = $request->validated();

        $supLieuDeVote = SupLieuDeVote::create($validated);

        return new SupLieuDeVoteResource($supLieuDeVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupLieuDeVote $supLieuDeVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SupLieuDeVote $supLieuDeVote)
    {
        $this->authorize('view', $supLieuDeVote);

        return new SupLieuDeVoteResource($supLieuDeVote);
    }

    /**
     * @param \App\Http\Requests\SupLieuDeVoteUpdateRequest $request
     * @param \App\Models\SupLieuDeVote $supLieuDeVote
     * @return \Illuminate\Http\Response
     */
    public function update(
        SupLieuDeVoteUpdateRequest $request,
        SupLieuDeVote $supLieuDeVote
    ) {
        $this->authorize('update', $supLieuDeVote);

        $validated = $request->validated();

        $supLieuDeVote->update($validated);

        return new SupLieuDeVoteResource($supLieuDeVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupLieuDeVote $supLieuDeVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SupLieuDeVote $supLieuDeVote)
    {
        $this->authorize('delete', $supLieuDeVote);

        $supLieuDeVote->delete();

        return response()->noContent();
    }
}
