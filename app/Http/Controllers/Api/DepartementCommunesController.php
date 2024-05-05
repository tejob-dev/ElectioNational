<?php
namespace App\Http\Controllers\Api;

use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneCollection;

class DepartementCommunesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Departement $departement)
    {
        $this->authorize('view', $departement);

        $search = $request->get('search', '');

        $communes = $departement
            ->communes()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommuneCollection($communes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Departement $departement,
        Commune $commune
    ) {
        $this->authorize('update', $departement);

        $departement->communes()->syncWithoutDetaching([$commune->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Departement $departement,
        Commune $commune
    ) {
        $this->authorize('update', $departement);

        $departement->communes()->detach($commune);

        return response()->noContent();
    }
}
