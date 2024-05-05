<?php

namespace App\Http\Controllers\Api;

use App\Models\Parrain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParrainResource;
use App\Http\Resources\ParrainCollection;
use App\Http\Requests\ParrainStoreRequest;
use App\Http\Requests\ParrainUpdateRequest;

class ParrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Parrain::class);

        $search = $request->get('search', '');

        $parrains = Parrain::search($search)
            ->userlimit()
            ->latest()
            ->paginate();

        return new ParrainCollection($parrains);
    }

    /**
     * @param \App\Http\Requests\ParrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParrainStoreRequest $request)
    {
        $this->authorize('create', Parrain::class);

        $validated = $request->validated();

        $parrain = Parrain::create($validated);

        return new ParrainResource($parrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Parrain $parrain)
    {
        $this->authorize('view', $parrain);

        return new ParrainResource($parrain);
    }

    /**
     * @param \App\Http\Requests\ParrainUpdateRequest $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function update(ParrainUpdateRequest $request, Parrain $parrain)
    {
        $this->authorize('update', $parrain);

        $validated = $request->validated();

        $parrain->update($validated);

        return new ParrainResource($parrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Parrain $parrain)
    {
        $this->authorize('delete', $parrain);

        $parrain->delete();

        return response()->noContent();
    }
}
