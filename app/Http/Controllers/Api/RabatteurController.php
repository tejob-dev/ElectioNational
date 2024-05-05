<?php

namespace App\Http\Controllers\Api;

use App\Models\Rabatteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RabatteurResource;
use App\Http\Resources\RabatteurCollection;
use App\Http\Requests\RabatteurStoreRequest;
use App\Http\Requests\RabatteurUpdateRequest;

class RabatteurController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Rabatteur::class);

        $search = $request->get('search', '');

        $rabatteurs = Rabatteur::search($search)
            ->latest()
            ->paginate();

        return new RabatteurCollection($rabatteurs);
    }

    /**
     * @param \App\Http\Requests\RabatteurStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RabatteurStoreRequest $request)
    {
        $this->authorize('create', Rabatteur::class);

        $validated = $request->validated();

        $rabatteur = Rabatteur::create($validated);

        return new RabatteurResource($rabatteur);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('view', $rabatteur);

        return new RabatteurResource($rabatteur);
    }

    /**
     * @param \App\Http\Requests\RabatteurUpdateRequest $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function update(
        RabatteurUpdateRequest $request,
        Rabatteur $rabatteur
    ) {
        $this->authorize('update', $rabatteur);

        $validated = $request->validated();

        $rabatteur->update($validated);

        return new RabatteurResource($rabatteur);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('delete', $rabatteur);

        $rabatteur->delete();

        return response()->noContent();
    }
}
