<?php

namespace App\Http\Controllers;

use App\Models\CorParrain;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.cor_parrains.index', compact('corParrains', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', CorParrain::class);

        return view('app.cor_parrains.create');
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

        return redirect()
            ->route('cor-parrains.edit', $corParrain)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CorParrain $corParrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CorParrain $corParrain)
    {
        $this->authorize('view', $corParrain);

        return view('app.cor_parrains.show', compact('corParrain'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CorParrain $corParrain
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CorParrain $corParrain)
    {
        $this->authorize('update', $corParrain);

        return view('app.cor_parrains.edit', compact('corParrain'));
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

        return redirect()
            ->route('cor-parrains.edit', $corParrain)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('cor-parrains.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
