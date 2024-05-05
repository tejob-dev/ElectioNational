<?php
namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use App\Models\Rabatteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LieuVoteCollection;

class RabatteurLieuVotesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('view', $rabatteur);

        $search = $request->get('search', '');

        $lieuVotes = $rabatteur
            ->lieuVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new LieuVoteCollection($lieuVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Rabatteur $rabatteur,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $rabatteur);

        $rabatteur->lieuVotes()->syncWithoutDetaching([$lieuVote->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Rabatteur $rabatteur,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $rabatteur);

        $rabatteur->lieuVotes()->detach($lieuVote);

        return response()->noContent();
    }
}
