<?php

namespace App\Http\Controllers;

use App\Models\ElectorParrain;
use Illuminate\Http\Request;
use App\Http\Requests\ElectorParrainStoreRequest;
use App\Http\Requests\ElectorParrainUpdateRequest;

class ElectorParrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ElectorParrain::class);

        $search = $request->get('search', '');

        $electorParrains = ElectorParrain::search($search)->where("elect_date", "=", "2023")
            ->orderBy("nom_prenoms", "desc")
            ->paginate(5)
            ->withQueryString();
        $curr_year = 2023;

        return view('app.elector_parrains.index', compact('electorParrains', 'search', 'curr_year'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function elector2024(Request $request)
    {
        $this->authorize('view-any', ElectorParrain::class);

        $search = $request->get('search', '');

        $electorParrains = ElectorParrain::search($search)->where("elect_date", "=", "2024")
            ->orderBy("nom_prenoms", "desc")
            ->paginate(5)
            ->withQueryString();
        $curr_year = 2024;

        return view('app.elector_parrains.index', compact('electorParrains', 'search', 'curr_year'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ElectorParrain::class);

        return view('app.elector_parrains.create');
    }

    /**
     * @param \App\Http\Requests\ElectorParrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ElectorParrainStoreRequest $request)
    {
        $this->authorize('create', ElectorParrain::class);

        $validated = $request->validated();

        $electorParrain = ElectorParrain::create($validated);

        return redirect()
            ->route('elector-parrains.edit', $electorParrain)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ElectorParrain $electorParrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ElectorParrain $electorParrain)
    {
        $this->authorize('view', $electorParrain);

        return view('app.elector_parrains.show', compact('electorParrain'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ElectorParrain $electorParrain
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ElectorParrain $electorParrain)
    {
        $this->authorize('update', $electorParrain);

        return view('app.elector_parrains.edit', compact('electorParrain'));
    }

    /**
     * @param \App\Http\Requests\ElectorParrainUpdateRequest $request
     * @param \App\Models\ElectorParrain $electorParrain
     * @return \Illuminate\Http\Response
     */
    public function update(
        ElectorParrainUpdateRequest $request,
        ElectorParrain $electorParrain
    ) {
        $this->authorize('update', $electorParrain);

        $validated = $request->validated();

        $electorParrain->update($validated);

        return redirect()
            ->route('elector-parrains.edit', $electorParrain)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ElectorParrain $electorParrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ElectorParrain $electorParrain)
    {
        $this->authorize('delete', $electorParrain);

        $electorParrain->delete();

        return redirect()
            ->route('elector-parrains.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
