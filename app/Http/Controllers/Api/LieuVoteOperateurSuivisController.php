<?php
namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Models\OperateurSuivi;
use App\Http\Controllers\Controller;
use App\Http\Resources\OperateurSuiviCollection;

class LieuVoteOperateurSuivisController extends Controller
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

        $operateurSuivis = $lieuVote
            ->operateurSuivis()
            ->search($search)
            ->latest()
            ->paginate();

        return new OperateurSuiviCollection($operateurSuivis);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LieuVote $lieuVote,
        OperateurSuivi $operateurSuivi
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote
            ->operateurSuivis()
            ->syncWithoutDetaching([$operateurSuivi->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LieuVote $lieuVote,
        OperateurSuivi $operateurSuivi
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote->operateurSuivis()->detach($operateurSuivi);

        return response()->noContent();
    }
}
