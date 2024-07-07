<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\LieuVote;
use App\Models\Quartier;
use Illuminate\Http\Request;
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
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.lieu_votes.index', compact('lieuVotes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', LieuVote::class);

        $communes = Commune::pluck('libel', 'id');

        return view('app.lieu_votes.create', compact('communes'));
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

        return redirect()
            ->route('lieu-votes.edit', $lieuVote)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('view', $lieuVote);

        return view('app.lieu_votes.show', compact('lieuVote'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, LieuVote $lieuVote)
    {
        $this->authorize('update', $lieuVote);

        $communes = Commune::pluck('libel', 'id');

        return view('app.lieu_votes.edit', compact('lieuVote', 'communes'));
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

        return redirect()
            ->route('lieu-votes.edit', $lieuVote)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('lieu-votes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
