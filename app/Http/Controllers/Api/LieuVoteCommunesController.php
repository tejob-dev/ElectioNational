<?php
namespace App\Http\Controllers\Api;

use App\Models\Commune;
use App\Models\LieuVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneCollection;

class LieuVoteCommunesController extends Controller
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

        $communes = $lieuVote
            ->communes()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommuneCollection($communes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        LieuVote $lieuVote,
        Commune $commune
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote->communes()->syncWithoutDetaching([$commune->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LieuVote $lieuVote
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        LieuVote $lieuVote,
        Commune $commune
    ) {
        $this->authorize('update', $lieuVote);

        $lieuVote->communes()->detach($commune);

        return response()->noContent();
    }
}
