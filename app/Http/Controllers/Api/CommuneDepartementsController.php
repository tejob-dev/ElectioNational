<?php
namespace App\Http\Controllers\Api;

use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartementCollection;

class CommuneDepartementsController extends Controller
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

        $departements = $commune
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new DepartementCollection($departements);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Commune $commune,
        Departement $departement
    ) {
        $this->authorize('update', $commune);

        $commune->sections()->syncWithoutDetaching([$departement->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Commune $commune,
        Departement $departement
    ) {
        $this->authorize('update', $commune);

        $commune->sections()->detach($departement);

        return response()->noContent();
    }
}
