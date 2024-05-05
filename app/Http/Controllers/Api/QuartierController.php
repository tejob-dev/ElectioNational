<?php

namespace App\Http\Controllers\Api;

use App\Models\Quartier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuartierResource;
use App\Http\Resources\QuartierCollection;
use App\Http\Requests\QuartierStoreRequest;
use App\Http\Requests\QuartierUpdateRequest;

class QuartierController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Quartier::class);

        $search = $request->get('search', '');

        $quartiers = Quartier::search($search)
            ->latest()
            ->paginate();

        return new QuartierCollection($quartiers);
    }

    /**
     * @param \App\Http\Requests\QuartierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuartierStoreRequest $request)
    {
        $this->authorize('create', Quartier::class);

        $validated = $request->validated();

        $quartier = Quartier::create($validated);

        return new QuartierResource($quartier);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Quartier $quartier)
    {
        $this->authorize('view', $quartier);

        return new QuartierResource($quartier);
    }

    /**
     * @param \App\Http\Requests\QuartierUpdateRequest $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function update(QuartierUpdateRequest $request, Quartier $quartier)
    {
        $this->authorize('update', $quartier);

        $validated = $request->validated();

        $quartier->update($validated);

        return new QuartierResource($quartier);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quartier $quartier)
    {
        $this->authorize('delete', $quartier);

        $quartier->delete();

        return response()->noContent();
    }
}
