<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\View\View;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DepartementStoreRequest;
use App\Http\Requests\DepartementUpdateRequest;

class DepartementController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Departement::class);

        $search = $request->get('search', '');

        $departements = Departement::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.departements.index',
            compact('departements', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Departement::class);

        $regions = Region::pluck('libel', 'id');

        return view('app.departements.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartementStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Departement::class);

        $validated = $request->validated();

        $departement = Departement::create($validated);

        return redirect()
            ->route('departements.edit', $departement)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Departement $departement): View
    {
        $this->authorize('view', $departement);

        return view('app.departements.show', compact('departement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Departement $departement): View
    {
        $this->authorize('update', $departement);

        $regions = Region::pluck('libel', 'id');

        return view('app.departements.edit', compact('departement', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DepartementUpdateRequest $request,
        Departement $departement
    ): RedirectResponse {
        $this->authorize('update', $departement);

        $validated = $request->validated();

        $departement->update($validated);

        return redirect()
            ->route('departements.edit', $departement)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Departement $departement
    ): RedirectResponse {
        $this->authorize('delete', $departement);

        $departement->delete();

        return redirect()
            ->route('departements.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
