<?php

namespace App\Http\Controllers\Api;

use App\Models\BureauVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BureauVoteResource;
use App\Http\Resources\BureauVoteCollection;
use App\Http\Requests\BureauVoteStoreRequest;
use App\Http\Requests\BureauVoteUpdateRequest;

class BureauVoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BureauVote::class);

        $search = $request->get('search', '');

        $bureauVotes = BureauVote::search($search)
            ->userlimit()
            ->latest()
            ->paginate();

        return new BureauVoteCollection($bureauVotes);
    }

    /**
     * @param \App\Http\Requests\BureauVoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BureauVoteStoreRequest $request)
    {
        $this->authorize('create', BureauVote::class);

        $validated = $request->validated();

        $bureauVote = BureauVote::create($validated);

        return new BureauVoteResource($bureauVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('view', $bureauVote);

        return new BureauVoteResource($bureauVote);
    }

    /**
     * @param \App\Http\Requests\BureauVoteUpdateRequest $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function update(
        BureauVoteUpdateRequest $request,
        BureauVote $bureauVote
    ) {
        $this->authorize('update', $bureauVote);

        $validated = $request->validated();

        $bureauVote->update($validated);

        return new BureauVoteResource($bureauVote);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('delete', $bureauVote);

        $bureauVote->delete();

        return response()->noContent();
    }
}
