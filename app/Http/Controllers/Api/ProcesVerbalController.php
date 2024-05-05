<?php

namespace App\Http\Controllers\Api;

use App\Models\ProcesVerbal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProcesVerbalResource;
use App\Http\Resources\ProcesVerbalCollection;
use App\Http\Requests\ProcesVerbalStoreRequest;
use App\Http\Requests\ProcesVerbalUpdateRequest;

class ProcesVerbalController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProcesVerbal::class);

        $search = $request->get('search', '');

        $procesVerbals = ProcesVerbal::search($search)
            ->userlimit()
            ->latest()
            ->paginate();

        return new ProcesVerbalCollection($procesVerbals);
    }

    /**
     * @param \App\Http\Requests\ProcesVerbalStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcesVerbalStoreRequest $request)
    {
        $this->authorize('create', ProcesVerbal::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $procesVerbal = ProcesVerbal::create($validated);

        return new ProcesVerbalResource($procesVerbal);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProcesVerbal $procesVerbal)
    {
        $this->authorize('view', $procesVerbal);

        return new ProcesVerbalResource($procesVerbal);
    }

    /**
     * @param \App\Http\Requests\ProcesVerbalUpdateRequest $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProcesVerbalUpdateRequest $request,
        ProcesVerbal $procesVerbal
    ) {
        $this->authorize('update', $procesVerbal);

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($procesVerbal->photo) {
                Storage::delete($procesVerbal->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $procesVerbal->update($validated);

        return new ProcesVerbalResource($procesVerbal);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProcesVerbal $procesVerbal)
    {
        $this->authorize('delete', $procesVerbal);

        if ($procesVerbal->photo) {
            Storage::delete($procesVerbal->photo);
        }

        $procesVerbal->delete();

        return response()->noContent();
    }
}
