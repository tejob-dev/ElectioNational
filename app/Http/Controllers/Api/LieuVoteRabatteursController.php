<?php
namespace App\Http\Controllers\Api;

use App\Models\LieuVote;
use App\Models\Rabatteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RabatteurCollection;

class LieuVoteRabatteursController extends Controller
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

        $rabatteurs = $lieuVote
            ->rabatteurs()
            ->search($search)
            ->latest()
            ->paginate();

        return new RabatteurCollection($rabatteurs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LieuVote $lieuVote,
        Rabatteur $rabatteur
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote->rabatteurs()->syncWithoutDetaching([$rabatteur->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LieuVote $lieuVote,
        Rabatteur $rabatteur
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote->rabatteurs()->detach($rabatteur);

        return response()->noContent();
    }
}
