<?php

namespace App\Http\Controllers\Api;

use App\Models\CorParrain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CorParrainResource;
use App\Http\Resources\CorParrainCollection;
use App\Http\Requests\CorParrainStoreRequest;
use App\Http\Requests\CorParrainUpdateRequest;

class CorParrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CorParrain::class);

        $search = $request->get('search', '');

        $corParrains = CorParrain::search($search)
            ->latest()
            ->paginate();

        return new CorParrainCollection($corParrains);
    }

    /**
     * @param \App\Http\Requests\CorParrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorParrainStoreRequest $request)
    {
        $this->authorize('create', CorParrain::class);

        $validated = $request->validated();

        $corParrain = CorParrain::create($validated);

        return new CorParrainResource($corParrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CorParrain $corParrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CorParrain $corParrain)
    {
        $this->authorize('view', $corParrain);

        return new CorParrainResource($corParrain);
    }

    /**
     * @param \App\Http\Requests\CorParrainUpdateRequest $request
     * @param \App\Models\CorParrain $corParrain
     * @return \Illuminate\Http\Response
     */
    public function update(
        CorParrainUpdateRequest $request,
        CorParrain $corParrain
    ) {
        $this->authorize('update', $corParrain);

        $validated = $request->validated();

        $corParrain->update($validated);

        return new CorParrainResource($corParrain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CorParrain $corParrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CorParrain $corParrain)
    {
        $this->authorize('delete', $corParrain);

        $corParrain->delete();

        return response()->noContent();
    }
}
