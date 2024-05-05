<?php

namespace App\Http\Controllers\Api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneResource;
use App\Http\Resources\CommuneCollection;
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
            ->latest()
            ->paginate();

        return new CommuneCollection($communes);
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

        return new CommuneResource($commune);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Commune $commune)
    {
        $this->authorize('view', $commune);

        return new CommuneResource($commune);
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

        return new CommuneResource($commune);
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

        return response()->noContent();
    }
}
