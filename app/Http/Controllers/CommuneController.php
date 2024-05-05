<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Requests\CommuneStoreRequest;
use App\Http\Requests\CommuneUpdateRequest;

class CommuneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Commune::class);

        $search = $request->get('search', '');

        $communes = Commune::search($search)
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.communes.index', compact('communes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Commune::class);

        return view('app.communes.create');
    }

    /**
     * @param \App\Http\Requests\CommuneStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommuneStoreRequest $request)
    {
        $this->authorize('create', Commune::class);

        $validated = $request->validated();

        $commune = Commune::create($validated);

        return redirect()
            ->route('communes.edit', $commune)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Commune $commune)
    {
        $this->authorize('view', $commune);

        return view('app.communes.show', compact('commune'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Commune $commune)
    {
        $this->authorize('update', $commune);

        return view('app.communes.edit', compact('commune'));
    }

    /**
     * @param \App\Http\Requests\CommuneUpdateRequest $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function update(CommuneUpdateRequest $request, Commune $commune)
    {
        $this->authorize('update', $commune);

        $validated = $request->validated();

        $commune->update($validated);

        return redirect()
            ->route('communes.edit', $commune)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Commune $commune)
    {
        $this->authorize('delete', $commune);

        $commune->delete();

        return redirect()
            ->route('communes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
