<?php
namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Models\OperateurSuivi;
use App\Http\Controllers\Controller;
use App\Http\Resources\LieuVoteCollection;

class OperateurSuiviLieuVotesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OperateurSuivi $operateurSuivi)
    {
        $this->authorize('view', $operateurSuivi);

        $search = $request->get('search', '');

        $lieuVotes = $operateurSuivi
            ->lieuVotes()
            ->search($search)
            ->latest()
            ->paginate();

        return new LieuVoteCollection($lieuVotes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        OperateurSuivi $operateurSuivi,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $operateurSuivi);

        $operateurSuivi->lieuVotes()->syncWithoutDetaching([$lieuVote->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @param \App\Models\LieuVote $lieuVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        OperateurSuivi $operateurSuivi,
        LieuVote $lieuVote
    ) {
        $this->authorize('update', $operateurSuivi);

        $operateurSuivi->lieuVotes()->detach($lieuVote);

        return response()->noContent();
    }
}
