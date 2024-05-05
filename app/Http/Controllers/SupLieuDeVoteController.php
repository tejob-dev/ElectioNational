<?php

namespace App\Http\Controllers;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Models\SupLieuDeVote;
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
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'app.sup_lieu_de_votes.index',
            compact('supLieuDeVotes', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SupLieuDeVote::class);

        $lieuVotes = LieuVote::pluck('libel', 'id');

        return view('app.sup_lieu_de_votes.create', compact('lieuVotes'));
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

        return redirect()
            ->route('sup-lieu-de-votes.edit', $supLieuDeVote)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupLieuDeVote $supLieuDeVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SupLieuDeVote $supLieuDeVote)
    {
        $this->authorize('view', $supLieuDeVote);

        return view('app.sup_lieu_de_votes.show', compact('supLieuDeVote'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupLieuDeVote $supLieuDeVote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SupLieuDeVote $supLieuDeVote)
    {
        $this->authorize('update', $supLieuDeVote);

        $lieuVotes = LieuVote::pluck('libel', 'id');

        return view(
            'app.sup_lieu_de_votes.edit',
            compact('supLieuDeVote', 'lieuVotes')
        );
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

        return redirect()
            ->route('sup-lieu-de-votes.edit', $supLieuDeVote)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sup-lieu-de-votes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
