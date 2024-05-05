<?php
namespace App\Http\Controllers\Api;

use App\Models\Commune;
use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LieuVoteCollection;

class CommuneLieuVotesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Commune $commune)
    {
        $this->authorize('view', $commune);

        $search = $request->get('search', '');

        $lieuVotes = $commune
            ->lieuVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new LieuVoteCollection($lieuVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Commune $commune,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $commune);

        $commune->lieuVotes()->syncWithoutDetaching([$lieuVote->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Commune $commune,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $commune);

        $commune->lieuVotes()->detach($lieuVote);

        return response()->noContent();
    }
}
